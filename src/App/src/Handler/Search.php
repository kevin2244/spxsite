<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Form\FormInterface;
use GuzzleHttp;
use GuzzleHttp\Exception\GuzzleException;

class Search implements RequestHandlerInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $renderer;
    private $form;
    private $spxClient;

    public function __construct(
        TemplateRendererInterface $renderer,
        FormInterface $form,
        GuzzleHttp\ClientInterface $spxClient)
    {
        $this->renderer = $renderer;
        $this->form = $form;
        $this->spxClient = $spxClient;
    }

    /**
     * {@inheritDoc}
     */
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $data = [];
        $searchresult = '[]';
        $searchInitiated = false;

        if ($request->getMethod() === 'POST') {
            $searchInitiated = true;
            $postData = $request->getParsedBody();
            $this->form->setData($postData);

            if ($this->form->isValid()) {
                $data['success'] = 'success';

                //send to API..
                try {
                    $searchresult = $this->spxClient->request('POST',
                        'search', ['json' => $postData])->getBody()->getContents();
                } catch (GuzzleException $e) {
                    error_log('Caught GuzzleException' . $e->getMessage(),
                        E_USER_ERROR);
                }
            }
            else {
                $data['success'] = 'Not Valid';
                $data['messages'] = $this->form->getMessages();
            }
        }
        $data['form'] = $this->form;
        $data['searchresult'] = $searchresult;
        $data['search_initiated'] = $searchInitiated;

        // Render and return a response:
        return new HtmlResponse($this->renderer->render(
            'app::search',
            $data // parameters to pass to template
        ));
    }
}
