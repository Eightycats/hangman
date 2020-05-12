<?php

namespace App\Action;

use App\Data\GameState;
use Slim\Http\Response;

class RedirectAction extends GameStateAction
{
    protected function display(Response $response, $game_state, $error) : Response
    {
        // we were unable to find the game state, perhaps because of server restart
        if (empty($game_state)) {
            // redirect to the home page to start a new game
            $response->withRedirect("/");
            return $response;
        }

        return $response->withRedirect(self::getDisplayURL($game_state));
    }
}
