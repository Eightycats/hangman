<?php

use Slim\App;

return function (App $app) {
    $app->get('/', \App\Action\GameViewAction::class);
    $app->get('/new', \App\Action\NewGameAction::class);
    $app->get('/display/{game_state_key}', \App\Action\DisplayAction::class);
    $app->get('/guess/{game_state_key}/{letter}', \App\Action\GuessLetterAction::class);
    $app->get('/guess_word/{game_state_key}/{word}', \App\Action\GuessWordAction::class);
};
