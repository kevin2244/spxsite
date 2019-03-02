<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response;
use Zend\Form\FormInterface;

class AddPhotosFormHandler implements RequestHandlerInterface
{
    /** @var FormInterface */
    private $form;

    public function __construct(FormInterface $form)
    {
        $this->form = $form;
    }

    /**
     * {@inheritDoc}
     */
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $params = $request->getParsedBody();
        $itemId = $params['itemid'];

        $post = array_merge_recursive(
            $request->getParsedBody(),
            $request->getUploadedFiles()
        );

        $this->form->setData($post);

        if ($this->form->isValid()) {
            $data['form_success'] = 'Valid';
        }

        //redirect
        return new Response\RedirectResponse('/item/'.$itemId);
    }
}
