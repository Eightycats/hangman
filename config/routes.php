<?php

use Slim\App;

return function (App $app) {
    $app->get('/', \App\Action\GameViewAction::class);
    $app->get('/new', \App\Action\NewGameAction::class);
    $app->get('/display/{game_state_key}', \App\Action\GameViewAction::class);
    $app->get('/guess/{game_state_key}/{letter}', \App\Action\GuessLetterAction::class);
    $app->post('/guess_word/{game_state_key}', \App\Action\GuessWordAction::class);
    $app->get('/reset', \App\Action\ResetAction::class);
};
