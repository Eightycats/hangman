<?php

namespace App\Action;

use App\View\GameView;
use Selective\Config\Configuration;
use Slim\Http\Response;
use Slim\Http\ServerRequest;

class GameViewAction extends GameStateAction
{
    private $settings;

    public function __construct(Configuration $settings)
    {
        $this->settings = $settings;
    }

    public function __invoke(ServerRequest $request, Response $response, $args): Response
    {
        $game_state = null;
        $error = false;

        try {
            $game_state = $this->invoke($response, $args);
        } catch (Exception $ex) {
            $error = $ex->getMessage();
        }

        $view = new GameView($this->settings->getString('templates') . '/' . $this->getTemplate() . '.php');
        $response->getBody()->write($view->render($game_state, $error));

        return $response;
    }

    protected function invoke(Response $response, $args)
    {
        return null;
    }

    protected function getTemplate()
    {
        // show hangman.php
        return 'hangman';
    }
}