<?php


namespace App\Data;


class Hangman
{
    private static $words = ['RABBIT', 'BUNNY', 'CARROT', 'LETTUCE', 'BURROW', 'FLUFFY', 'FLOPPY', 'LITTER', 'PELLETS'];

    public static function newGame() : GameState
    {
        if (!empty(self::$words)) {
            // randomly select a word
            $selected = array_rand(self::$words);
            $word = self::$words[$selected];

            // remove so it can't be used in the future
            unset(self::$words[$selected]);

            return new GameState($word);
        }
        throw new Exception("Sorry. No more new words.");
    }
}