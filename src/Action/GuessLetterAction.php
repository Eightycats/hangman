<?php

namespace App\Action;

use Slim\Http\Response;
use Slim\Http\ServerRequest;

class GuessLetterAction extends RedirectAction
{
    protected function invoke(ServerRequest $request, Response $response, $args, $game_state)
    {
        return $game_state->guessLetter($args['letter']);
    }
}