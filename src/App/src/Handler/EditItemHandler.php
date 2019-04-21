<?php
/**
 * @copyright Kevin Smith 2018
 */
declare(strict_types=1);

namespace App\Handler;

use App\Forms\AddPhotosForm;
use App\Forms\EditItemForm;
use App\Helpers\IdentHelper;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\I18n\Validator\Alnum;
use Zend\Psr7Bridge\Psr7ServerRequest;
use Zend\Validator\ValidatorChain;
use function error_log;


class EditItemHandler implements RequestHandlerInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $renderer;

    /** @var ClientInterface */
    private $spxClient;

    /** @var AddPhotosForm */
    private $addPhotosForm;

    /** @var EditItemForm */
    private $editItemForm;

    /** @var UrlHelper */
    private $urlHelper;

    /** @var IdentHelper */
    private $identHelper;

    /** @var array */
    private $config;

    public function __construct(
        TemplateRendererInterface $renderer,
        ClientInterface $spxClient,
        AddPhotosForm $addPhotosForm,
        UrlHelper $urlHelper,
        IdentHelper $identHelper,
        EditItemForm $editItemForm,
        $config
    ) {
        $this->renderer = $renderer;
        $this->spxClient = $spxClient;
        $this->addPhotosForm = $addPhotosForm;
        $this->urlHelper = $urlHelper;
        $this->identHelper = $identHelper;
        $this->editItemForm = $editItemForm;
        $this->config = $config;
    }

    /**
     * {@inheritDoc}
     */
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {

        $ih = $this->identHelper;
        $userId = $ih()['_id']['$oid'];

        $upStatusMessage = '';
        $itemId = $request->getAttribute('itemid');

        $inputValidatorChain = new ValidatorChain();
        $inputValidatorChain->attach(new Alnum());

        $messages = [];

        if (!$inputValidatorChain->isValid($itemId)) {
            return new HtmlResponse($this->renderer->render('error::404'), 404);
        }

        //add seller ID to query options...
        $uriQueryOptions['query']['sellerid'] = $userId;
        $uriQueryOptions['query']['_id'] = $itemId;

        try {
            $itemData = json_decode($this->spxClient->request('GET', "cars-for-sale", $uriQueryOptions)->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            $itemData = [];
            error_log(
                'GuzzleException ' . $e->getMessage(),
                E_USER_ERROR
            );
        }

        $photoData = [];
        if($itemData['_total_items'] === 1) {
            try {
                $photoData = json_decode($this->spxClient->request('GET',
                    "edit-car-photos/id/$itemId")->getBody()->getContents(),
                    true);
            } catch (GuzzleException $e) {
                $photoData = [];

                error_log(
                    'GuzzleException ' . $e->getMessage(),
                    E_USER_ERROR
                );
            }
        }

        if ($request->getMethod() === 'POST') {

            $params = $request->getParsedBody();

            $formNameId = $params['form-name-id'] ?? null;

            if ($formNameId === 'add-photo') {

                //set data
                $zendRequest = Psr7ServerRequest::toZend($request);
                $post = \array_merge_recursive(
                    $zendRequest->getPost()->toArray(),
                    $zendRequest->getFiles()->toArray()
                );

                $this->addPhotosForm->setData($post);

                if ($this->addPhotosForm->isValid()) {
                    $data['form_success'] = 'Valid';

                    //process it (filters applied on the call to getdata())
                    $fdata = $this->addPhotosForm->getData();
                    $tmpImg = $fdata['image1']['tmp_name'];
                    $stream = Psr7\stream_for(file_get_contents($tmpImg));

                    //\Psr7\stream_for('contents...')

                    //send to SPX API
                    try {
                        $addPhotoResponse = $this->spxClient->request('POST',
                            "add-car-photo/itemid/$itemId",
                            ['body' => $stream]);
                    } catch (GuzzleException $e) {
                        error_log(
                            'GuzzleException' . $e->getMessage(),
                            E_USER_ERROR
                        );
                    }

                    $upStatusMessage = '';
                    if (!empty($addPhotoResponse)) {

                        $upStatus = $addPhotoResponse->getStatusCode();

                        switch ($upStatus) {
                            case 201:
                                $upStatusMessage = 'Photo added OK';
                                break;
                            default:
                                $upStatusMessage
                                    = 'There was a problem adding the photo';
                        }
                    }
                } else {
                    $messages = $this->addPhotosForm->getMessages();
                }
            }
            elseif ($formNameId === 'edit-item') {

                $data['add_item_success'] = false;
                $this->editItemForm->setData($params);

                if ($this->editItemForm->isValid()) {

                    $data['form_success'] = 'Valid';

                    $newItemData = $this->editItemForm->getData();
                    $newItemData['sellerid'] = $userId;

                    try {
                        $response = $this->spxClient->request(
                            'PUT',
                            'edit-car-for-sale',
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
                    }
                } else {
                    $data['form_success'] = 'Form Not Valid';
                }
            }
        }

        //get data
        try {
            $itemvals = json_decode($this->spxClient->request('GET', "car-for-sale/id/$itemId")->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            $itemData = [];
            error_log(
                'GuzzleException' . $e->getMessage(),
                E_USER_ERROR
            );
        }

        //populate form data...
        $this->editItemForm->populateValues($itemvals);
        $this->editItemForm->setData(['id' => $itemId]);

        $data = [];
        $data['itemid'] = $itemId;
        $data['itemdata'] = $itemData;
        $data['modelid'] = $itemId;
        $data['photos'] = $photoData;
        $data['form'] = $this->addPhotosForm;
        $data['edititemform'] = $this->editItemForm;
        $data['upStatusMessage'] = $upStatusMessage;
        $data['messages'] = $messages;

        // Render and return a response:
        return new HtmlResponse($this->renderer->render(
            'app::edititem',
            $data // parameters to pass to template
        ));
    }
}