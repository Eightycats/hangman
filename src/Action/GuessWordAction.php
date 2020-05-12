<?php

namespace App\Action;

use Slim\Http\Response;
use Slim\Http\ServerRequest;

class GuessWordAction extends RedirectAction
{
    protected function invoke(ServerRequest $request, Response $response, $args, $game_state)
    {
        // TODO get param from request
        return $game_state->guessWord($args['word']);
    }
}