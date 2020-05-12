<?php

namespace App\Action;

use App\Data\GameState;
use Slim\Http\Response;
use Slim\Http\ServerRequest;

abstract class GameStateAction
{
    /**
     * HTTP call entry point. Gets the game state, modifies or creates the next state as needed, and then displays
     * the new state.
     */
    public function __invoke(ServerRequest $request, Response $response, $args): Response
    {
        $game_state = null;
        $error = false;

        try {
            $game_state = $this->getGameState($args);

            // callout to do the specific action
            $game_state = $this->invoke($request, $response, $args, $game_state);
        } catch (\Exception $ex) {
            $error = $ex->getMessage();
            error_log("EXCEPTION: " . $error);
        }

        return $this->display($response, $game_state, $error);
    }

    protected function getGameState($args)
    {
        $game_state_key = isset($args['game_state_key']) ? $args['game_state_key'] : null;
        $game_state = null;
        if (isset($game_state_key)) {
            $game_state = GameState::getGameState($game_state_key);
        }
        return $game_state;
    }

    protected function invoke(ServerRequest $request, Response $response, $args, $game_state)
    {
        // nothing to do by default
        return $game_state;
    }

    protected abstract function display(Response $response, $game_state, $error) : Response;

    public static function getDisplayURL(GameState $game_state)
    {
        $key = $game_state->getKey();
        if (isset($key)) {
            return "/display/" . $key;
        }
    }
}
