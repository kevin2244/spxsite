<?php
/**
 * @copyright Kevin Smith 2018
 */
declare(strict_types=1);

namespace App\Handler;

use App\Helpers\IdentHelper;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Form\FormInterface;
use Zend\Session\Container;
use function error_log;
use function print_r;

class AddItemStepsHandler implements RequestHandlerInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $renderer;

    /** @var ClientInterface  */
    private $spxClient;

    /** @var FormInterface  */
    private $step1form;

    /** @var FormInterface  */
    private $step2form;

    /** @var FormInterface  */
    private $step3form;

    /** @var IdentHelper  */
    private $identHelper;

    /** @var  Container*/
    private $session;

    public function __construct(
        TemplateRendererInterface $renderer,
        FormInterface $step1form,
        FormInterface $step2form,
        FormInterface $step3form,
        ClientInterface $spxClient,
        IdentHelper $identHelper
    ) {
        $this->renderer = $renderer;
        $this->step1form = $step1form;
        $this->step2form = $step2form;
        $this->step3form = $step3form;
        $this->spxClient = $spxClient;
        $this->identHelper = $identHelper;
    }

    /**
     * {@inheritDoc}
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->session = new Container('add_item_step');

        if ($request->getAttribute('clear')) {
            $this->session->exchangeArray([]);
            $this->session->step = 1;
        }

        $curstep = $this->session->step ?? 1;
        $this->session->step = $curstep;

        $stepform   = 'step'.(string) $curstep.'form';
        $ih         = $this->identHelper;
        $id         = $ih()['_id']['$oid'];
        $data       = [];
        $finalstep  = 3;
        $renderForm = false;
        $handleform = false;

        if ($request->getMethod() === 'POST') {
            $postData = $request->getParsedBody();
            $postid = $postData['postid'] ?? null;
            if (strpos($postid,  'addacar-step')  !== false) {
                $handleform = true;
            }
        }

        if ($handleform) {


            $this->$stepform->setData($postData);

            if ($this->$stepform->isValid()) {

                $data['form_success'] = 'Valid';

                $dataStep = 'data_step_'.(string) $curstep;

                $this->session->$dataStep = $this->$stepform->getData();

                if ($curstep === $finalstep) {

                    $data['add_item_success'] = false;

                    $newItemData = array_merge(
                        $this->session->data_step_1,
                        $this->session->data_step_2,
                        $this->session->data_step_3
                    );

                    $newItemData['sellerid'] = $id;

                    try {
                        $response = $this->spxClient->request(
                            'POST',
                            'add-car-for-sale',
                            ['json' => $newItemData]
                        );
                    } catch (GuzzleException $e) {
                        error_log('Guzzle Exception: ' .
                            $e->getMessage(), E_USER_ERROR);
                    }

                    //parse response
                    $addItemResponse = (!empty($response))
                        ?
                        json_decode($response->getBody()->getContents(), true)
                        :
                        [];
                    error_log('Add Item Response: '.print_r($addItemResponse,true));
                    if (!empty($addItemResponse['add_car_success'])) {

                        $data['add_item_success'] = true;
                        $this->session->exchangeArray([]);
                        return new RedirectResponse('edititem/'.$addItemResponse['id']);

                    } else {
                        $renderForm = true;
                    }
                }
                else {

                    $this->session->step = $this->session->step + 1;
                    $stepform = 'step'.(string) ($curstep + 1) .'form';
                    $renderForm = true;
                }

            } else {
                $data['form_success'] = 'Form Not Valid';
                $renderForm = true;
            }
        } else {
            $renderForm = true;
        }

        if ($renderForm) {
            $data['form'] = $this->$stepform;
            $data['messages'] = $this->$stepform->getMessages();
        }

        return new HtmlResponse($this->renderer->render(
            'app::add-item',
            $data
        ));
    }
}
