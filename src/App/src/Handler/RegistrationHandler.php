<?php
/**
 * SPX Site
 *
 * @copyright Kevin Smith 2018
 */
declare(strict_types=1);

namespace App\Handler;

use GuzzleHttp;
use GuzzleHttp\Exception\GuzzleException;
use Mailgun\Mailgun;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Helper\ServerUrlHelper;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Form\FormInterface;

class RegistrationHandler implements RequestHandlerInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $renderer;
    private $form;
    private $spxClient;
    private $urlHelper;
    private $serverUrlHelper;
    private $mailgunConfig;

    public function __construct(
        TemplateRendererInterface $renderer,
        FormInterface $form,
        GuzzleHttp\ClientInterface $spxClient,
        ServerUrlHelper $serverUrlHelper,
        UrlHelper $urlHelper,
        $mailgunConfig
    ) {
        $this->renderer = $renderer;
        $this->form = $form;
        $this->spxClient = $spxClient;
        $this->serverUrlHelper = $serverUrlHelper;
        $this->urlHelper = $urlHelper;
        $this->mailgunConfig = $mailgunConfig;
    }

    /**
     * {@inheritDoc}
     */
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $data = [];
        $renderForm = false;

        if ($request->getMethod() === 'POST') {
            $postData = $request->getParsedBody();
            $this->form->setData($postData);

            if ($this->form->isValid()) {
                $data['form_success'] = 'Valid';

                try {
                    $person = [
                        'firstname'           => $postData['firstname'],
                        'lastname'            => $postData['lastname'],
                        'address_first_line'  => $postData['address_first_line'],
                        'address_second_line' => $postData['address_second_line'],
                        'post_town'           => $postData['post_town'],
                        'post_code'           => $postData['post_code'],
                        'county'              => $postData['county'],
                        'phone'               => $postData['phone'],
                        'email'               => $postData['email']
                    ];

                    //don't send empty fields to the API which it may
                    //reject as invalid
                    foreach ($person as $personField => $fieldVal) {
                        if (empty($fieldVal)) {
                            unset($person[$personField]);
                        }
                    }

                    $newUserData['person'] = $person;
                    $newUserData['username'] = $postData['username'];
                    $newUserData['new_password'] = $postData['password'];

                    $response = $this->spxClient->request(
                        'POST',
                        'adduser',
                        ['json' => $newUserData]
                    );
                } catch (GuzzleException $e) {
                    if ($e instanceof GuzzleHttp\Exception\RequestException) {
                        // replace the original message (possibly truncated),
                        // with the full text of the response body.
                        if (!empty($e->getResponse())) {
                            $message = str_replace(
                                rtrim($e->getMessage()),
                                (string)$e->getResponse()->getBody(),
                                (string)$e
                            );
                        } else {
                            $message = $e->getMessage();
                        }
                        error_log('Guzzle RequestException: ' .
                            $message, E_USER_ERROR);
                    } else {
                        error_log('GuzzleException: '
                            . $e->getMessage()
                            . $e->getFile()
                            . $e->getLine(), E_USER_ERROR);
                    }
                }

                $addUserResponse = (!empty($response))
                    ?
                    json_decode($response->getBody()->getContents(), true)
                    :
                    [];

                if (!empty($addUserResponse['add_user_success'])) {
                    //Look Up User
                    try {
                        $userResponse = $this->spxClient->request(
                            'POST',
                            '/users',
                            ['json' => ['username' => $postData['username']]]
                        );
                    } catch (GuzzleException $e) {
                        error_log('GuzzleException: ' . $e->getMessage()
                            . $e->getFile() . $e->getLine(), E_USER_ERROR);
                    }
                    $userDataResponse = json_decode($userResponse->getBody()
                        ->getContents(), true);
                    $userData = reset($userDataResponse);
                    $token = $userData['verification_token'];

                    //TODO - Consider to put verification request to user in API...
                    //Send verification request to the User
                    $data['user_add_success'] = true;

                    //Instantiate the Mailgun SDK with API credentials
                    $mg
                        = Mailgun::create($this->mailgunConfig['mailgun_api_key']);

                    $serverUrlHelper = $this->serverUrlHelper;
                    $urlHelper = $this->urlHelper;
                    $link = $serverUrlHelper($urlHelper(
                        'verify',
                        ['token' => $token]
                    ));

                    $messageText
                        = <<<EOF
                    Please follow this $link                
                    Or copy and paste it into your browser's address bar and press Enter.
EOF;

                    # Now, compose and send your message.
                    # $mg->messages()->send($domain, $params);

                    $mg->messages()->send($this->mailgunConfig['domain'], [
                        'from'    => $this->mailgunConfig['from'],
                        'to'      => $newUserData['person']['email'],
                        'subject' => 'Scrappage Registration',
                        'text'    => $messageText,
                    ]);

                    $data['verification_email_sent_to'] = $newUserData['person']['email'];
                } else {
                    $data['user_add_success'] = false;
                }
            } else {
                $data['form_success'] = 'Form Not Valid';
                $renderForm = true;
            }
        } else {
            $renderForm = true;
        }

        if ($renderForm) {
            $data['form'] = $this->form;
            $data['messages'] = $this->form->getMessages();
        }

        return new HtmlResponse($this->renderer->render(
            'app::registration',
            $data
        ));
    }
}
