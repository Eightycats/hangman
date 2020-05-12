<?php

namespace App\Action;

use App\View\GameView;
use Selective\Config\Configuration;
use Slim\Http\Response;

class GameViewAction extends GameStateAction
{
    private $settings;

    public function __construct(Configuration $settings)
    {
        $this->settings = $settings;
    }

    protected function display(Response $response, $game_state, $error): Response
    {
        $view = new GameView($this->settings->getString('templates') . '/hangman.php');
        $response->getBody()->write($view->render($game_state, $error));

        return $response;
    }
}