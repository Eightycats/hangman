<?php

namespace App\Action;

use App\Data\Hangman;
use Slim\Http\Response;
use Slim\Http\ServerRequest;

class DisplayAction extends TemplateAction
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

        $content = [
            'game_state' => $game_state
        ];

        return $this->writeResponse($response, $content);
    }

    protected function getTemplate()
    {
        return 'hangman';
    }
}
