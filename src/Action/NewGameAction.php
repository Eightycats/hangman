<?php

namespace App\Action;

use App\Data\GameState;
use Slim\Http\Response;
use Slim\Http\ServerRequest;

class NewGameAction extends RedirectAction
{
    /**
     * Overridden to create new game.
     */
    protected function invoke(ServerRequest $request, Response $response, $args, $game_state)
    {
        return GameState::newGame();
    }
}
