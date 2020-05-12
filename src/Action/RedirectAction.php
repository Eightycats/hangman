<?php

namespace App\Action;

use App\Data\GameState;
use Slim\Http\Response;
use Slim\Http\ServerRequest;

class RedirectAction extends GameStateAction
{
    public function __invoke(ServerRequest $request, Response $response, $args): Response
    {
        $game_state = $this->getGameState($args);

        // check if we were unable to find a state with that key, perhaps because of server restart
        if (empty($game_state)) {
            // redirect to the home page to start a new game
            $response->withRedirect("/");
            return $response;
        }

        // callout to do the specific action
        $game_state = $this->invoke($response, $args, $game_state);

        return $this->display($response, $game_state);
    }

    protected function invoke(Response $response, $args, GameState $game_state)
    {
        // do nothing by default
        return $game_state;
    }

    protected function display(Response $response, GameState $game_state) : Response
    {
        return $response->withRedirect(self::getDisplayURL($game_state));
    }

    public static function getDisplayURL(GameState $game_state)
    {
        $key = $game_state->getKey();
        if (isset($key)) {
            return "/display/" . $key;
        }
    }
}
