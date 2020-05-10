<?php


namespace App\Data;

class GameState
{
    const MAX_GUESSES = 8;

    const SPACER = '_';

    private static int $key_counter = 0;

    private static array $state_map = [];

    private int $key;

    /** The target word. */
    private String $word;

    private array $guessedLetters = [];

    private String $wordGuess;

    private String $wordMask;

    private GameState $previousState;

    function __construct($word)
    {
        $this->key = self::$key_counter++;
        $this->word = $word;
        // create empty "mask" with same length as word
        $this->wordMask = str_repeat(GameState::SPACER, strlen($word));

        // create mapping of from the key to this state
        self::$state_map[$this->key] = $this;
    }

    public static function getGameState($game_state_key) : GameState
    {
        return isset(self::$state_map[$game_state_key]) ? self::$state_map[$game_state_key] : null;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getGuessCount()
    {
        return count($this->guessedLetters);
    }

    /**
     * Gets the version of the target word with underscores for any un-guessed letters.
     */
    public function getWordMask()
    {
        if ($this->isGameOver()) {
            // show them the full answer
            return $this->word;
        }
        return $this->wordMask;
    }

    public function hasPreviousState()
    {
        return !empty($this->previousState);
    }

    /**
     * Useful for "back" button.
     */
    public function getPreviousStateKey()
    {
        return $this->hasPreviousState() ? $this->previousState : null;
    }

    public function guessLetter($letter) : GameState
    {
        if ($this->isGameOver()) {
            return $this;
        }
        // TODO check if letter is valid

        // normalize to all uppercase letters
        $letter = strtoupper($letter);

        // check if letter has already been guessed
        if ($this->hasAlreadyGuessed($letter)) {
            return $this;
        }

        $next = new GameState($this->word);
        // copied by value
        $next->guessedLetters = $this->guessedLetters;
        // add new letter to beginning of array
        array_unshift($next->guessedLetters, $letter);

        // generate word "mask" containing letters guessed so far
        $mask = "";
        for ($i = 0; $i < strlen($next->word); $i++) {
            $c = $next->word[$i];
            if ($next->hasAlreadyGuessed($c)) {
                $mask[$i] = $c;
            } else {
                $mask[$i] = GameState::SPACER;
            }
        }
        $next->wordMask = $mask;

        $next->previousState -> $this;

        return $next;
    }

    public function hasAlreadyGuessed($letter)
    {
        return in_array($letter, $this->guessedLetters);
    }

    public function setWordGuess($word_guess)
    {
        if (!$this->isGameOver()) {
            $this->wordGuess = $word_guess;
        }
        return $this->isWin();
    }

    public function isGameOver()
    {
        return $this->isWin() || $this->isLose();
    }

    public function isWin()
    {
        return $this->isGuessCorrect() || $this->allLettersGuessed();
    }

    public function isLose()
    {
        return $this->getGuessCount() >= GameState::MAX_GUESSES ||
            (isset($this->wordGuess) && !$this->isGuessCorrect());
    }

    public function isGuessCorrect()
    {
        return $this->word === $this->wordGuess;
    }

    /**
     * Checks whether we've guessed all the letters correctly.
     */
    public function allLettersGuessed()
    {
        return strpos(!$this->getWordMask(), GameState::SPACER) === false;
    }
}