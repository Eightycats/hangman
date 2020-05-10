<?php


namespace App\Action;

use App\Data\GameState;
use App\Data\Hangman;

class NewGameAction extends RedirectAction
{
    /**
     * Overridden to create new game.
     */
    protected function getGameState($args) : GameState
    {
        try {
            return Hangman::newGame();
        } catch (Exception $ex) {
            // TODO where to go with errors?
        }
        return null;
    }
}