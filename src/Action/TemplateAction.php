<?php

namespace App\Action;

use App\Template;

use Selective\Config\Configuration;
use Slim\Http\Response;

abstract class TemplateAction extends BaseAction
{
    private $settings;

    public function __construct(Configuration $settings)
    {
        $this->settings = $settings;
    }

    protected function writeTemplate(Response $response, $result, $template) : Response
    {
        $temp = $this->createTemplate($template);
        $response->getBody()->write($temp->render($result));
        return $response;
    }

    protected function writeResponse(Response $response, $result) : Response
    {
        return $this->writeTemplate($response, $result, $this->getTemplate());
    }

    protected function writeErrorResponse(Response $response, $result) : Response
    {
        return $this->writeTemplate($response, $result, $this->getErrorTemplate());
    }

    protected function createTemplate($template)
    {
        return new Template($this->settings->getString('templates') . '/' . $template . '.php');
    }

    protected abstract function getTemplate();

    protected function getErrorTemplate()
    {
        return 'error';
    }

}