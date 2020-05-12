<?php

namespace App\Action;

use App\Data\GameState;

abstract class GameStateAction
{
    protected function getGameState($args)
    {
        $game_state_key = isset($args['game_state_key']) ? $args['game_state_key'] : null;
        $game_state = null;
        if (isset($game_state_key)) {
            $game_state = GameState::getGameState($game_state_key);
        }
        return $game_state;
    }
}
