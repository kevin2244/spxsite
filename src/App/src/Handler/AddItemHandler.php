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
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Form\FormInterface;
use function array_intersect_key;
use function error_log;

class AddItemHandler implements RequestHandlerInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $renderer;
    private $spxClient;
    private $form;
    private $identHelper;

    public function __construct(
        TemplateRendererInterface $renderer,
        FormInterface $form,
        ClientInterface $spxClient,
        IdentHelper $identHelper
    ) {
        $this->renderer = $renderer;
        $this->form = $form;
        $this->spxClient = $spxClient;
        $this->identHelper = $identHelper;
    }

    /**
     * {@inheritDoc}
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $ih = $this->identHelper;
        $id = $ih()['_id']['$oid'];

        $data = [];
        $renderForm = false;

        $handleform = false;
        if ($request->getMethod() === 'POST') {
            $postData = $request->getParsedBody();
            $postid = $postData['postid'] ?? null;
            if ($postid === 'addcar') {
                $handleform = true;
            }
        }

        if ($handleform) {

            $data['add_item_success'] = false;
            $this->form->setData($postData);

            if ($this->form->isValid()) {
                $data['form_success'] = 'Valid';
                $itemDataFields = [
                    'color',
                    'marque',
                    'model',
                    'doors',
                    'fuel',
                    'transmission',
                    'price',
                    'description',
                    'item_location',
                    'contact_phone'
                ];

                $newItemData = array_intersect_key($postData, array_flip($itemDataFields));

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
                if (!empty($addItemResponse['add_car_success'])) {
                    $data['add_item_success'] = true;
                } else {
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
            $data['form'] = $this->form;
            $data['messages'] = $this->form->getMessages();
        }

        return new HtmlResponse($this->renderer->render(
            'app::add-item',
            $data
        ));
    }
}
