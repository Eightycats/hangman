<?php


namespace App\Action;


use App\Data\GameState;
use Slim\Http\Response;

class GuessLetterAction extends RedirectAction
{
    protected function invoke(Response $response, $args, GameState $game_state)
    {
        return $game_state->guessLetter($args['letter']);
    }
}