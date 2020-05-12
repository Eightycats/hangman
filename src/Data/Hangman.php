<?php


namespace App\Data;


class Hangman
{
    // TODO cache this too
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
        throw new Exception("Sorry. Ran out of new words.");
    }
}