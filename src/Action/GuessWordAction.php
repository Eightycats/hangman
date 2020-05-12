<?php

namespace App\Action;

use Slim\Http\Response;
use Slim\Http\ServerRequest;

class GuessWordAction extends RedirectAction
{
    protected function invoke(ServerRequest $request, Response $response, $args, $game_state)
    {
        $guess = $request->getParam('guess');
        if (!isset($guess)) {
            // no guess? just go back to displaying the current state
            return $game_state;
        }
        return $game_state->guessWord($guess);
    }
}