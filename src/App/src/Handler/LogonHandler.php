<?php
/**
 * SPX Site
 *
 * @copyright Kevin Smith 2018
 */
declare(strict_types=1);

namespace App\Handler;

use App\Auth\AuthAdapter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Form\FormInterface;

class LogonHandler implements RequestHandlerInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $renderer;
    private $authService;
    private $authAdapter;
    private $form;

    public function __construct(
        TemplateRendererInterface $renderer,
        AuthenticationService $authService,
        AuthAdapter $authAdapter,
        FormInterface $form
    ) {
        $this->renderer = $renderer;
        $this->authService = $authService;
        $this->authAdapter = $authAdapter;
        $this->form = $form;
    }

    /**
     * {@inheritDoc}
     */
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $data = [];
        $authresult = [];


        //if POST and valid, redirect to index
        //otherwise render logon form



        if ($request->getMethod() === 'POST') {
            $postData = $request->getParsedBody();
            $this->form->setData($postData);

            if ($this->form->isValid()) {
                $authresult = $this->authenticate($request);

                if ($authresult['isValid']) {
                    return new RedirectResponse('/');
                }
            } else {
                $data['success'] = 'Not Valid';
            }
        }


        $data['form'] = $this->form;
        $data['messages'] = $this->form->getMessages();
        $data['authresult'] = $authresult;

        return new HtmlResponse($this->renderer->render(
            'app::logon',
            $data // parameters to pass to template
        ));
    }

    private function authenticate(ServerRequestInterface $request)
    {
        $authresult = [];
        $authresult['isValid'] = false;
        $params = $request->getParsedBody();

        if (empty($params['username'])) {
            $authresult['error'] = 'The username cannot be empty';
            return $authresult;
        }

        if (empty($params['password'])) {
            $authresult['username'] = $params['username'];
            $authresult['error']    = 'The password cannot be empty';
            return $authresult;
        }

        $this->authAdapter->setUsername($params['username']);
        $this->authAdapter->setPassword($params['password']);

        $result = $this->authService->authenticate();
        if (!$result->isValid()) {
                $authresult['username'] = $params['username'];
                $authresult['error']    = 'The credentials provided are not valid';
        } else {
            $authresult['isValid'] =  true;
        }

        return $authresult;
    }
}
