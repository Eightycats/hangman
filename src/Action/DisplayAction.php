<?php

namespace App\Action;

use Slim\Http\Response;

class DisplayAction extends GameViewAction
{
    public function invoke(Response $response, $args)
    {
        $game_state = $this->getGameState($args);

        // check if we were unable to find a state with that key, perhaps because of server restart
        if (!isset($game_state)) {
            // redirect to the home page where they can start a new game
            return $response->withRedirect("/");
        }

        return $game_state;
    }
}
