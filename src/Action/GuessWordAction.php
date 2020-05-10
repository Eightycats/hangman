<?php


namespace App\Action;


use App\Data\GameState;
use Slim\Http\Response;

class GuessWordAction extends RedirectAction
{
    protected function invoke(Response $response, $args, GameState $game_state)
    {
        $game_state->setWordGuess($args['word']);
        return $game_state;
    }
}