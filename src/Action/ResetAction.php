<?php


namespace App\Action;


use App\Data\GameState;
use Slim\Http\Response;
use Slim\Http\ServerRequest;

/**
 * Meant for testing/demo only. Resets the list of words.
 */
class ResetAction extends RedirectAction
{
    protected function invoke(ServerRequest $request, Response $response, $args, $game_state)
    {
        GameState::resetWords();
        return parent::invoke($request, $response, $args, $game_state);
    }
}