<?php


namespace App\Data;


class GameState
{
    /** The set of available words. */
    private static $words;

    /** Cache to maintain state between calls. */
    private static $cache;

    /** ID to uniquely identify this state. */
    protected $key;

    /** The target word. */
    protected String $word;

    /** Target word with underscores for missing letters. */
    protected String $wordMask;

    /** Letters guessed so far. */
    protected array $guessedLetters = [];

    /** Word guessed by player. If this is set, the game is over. */
    protected $wordGuess;

    /** Key for the state that came before this one, if any. */
    protected $previousState;

    function __construct($word)
    {
        $this->key = self::generateKey();
        $this->word = $word;
        $this->wordMask = "";
        $this->makeMask();
        $this->wordGuess = null;

        // create mapping from the key to this state
        self::cacheState();
    }

    public static function newGame() : GameState
    {
        return new GameState(self::nextWord());
    }

    public static function nextWord()
    {
        $cache = self::getCache();

        if (!empty($cache->words)) {
            // randomly select a word
            $selected_index = array_rand($cache->words);
            $word = $cache->words[$selected_index];

            // remove word so it can't be used in the future
            unset($cache->words[$selected_index]);

            self::saveCache();

            return $word;
        }
        throw new \Exception("Sorry. We ran out of new words.");
    }

    protected function clone ()
    {
        $copy = new GameState($this->word);
        // copied by value
        $copy->guessedLetters = $this->guessedLetters;
        $copy->wordGuess = $this->wordGuess;
        $copy->previousState = $this->getKey();

        return $copy;
    }

    protected function makeMask ()
    {
        // generate word "mask" containing letters guessed so far
        $mask = "";
        for ($i = 0; $i < strlen($this->word); $i++) {
            $c = $this->word[$i];
            if ($this->hasGuessedLetter($c)) {
                $mask[$i] = $c;
            } else {
                $mask[$i] = GameConstants::SPACER;
            }
        }
        $this->wordMask = $mask;
    }

    public static function getGameState($game_state_key)
    {
        $map = self::getStateMap();
        return isset($map->{$game_state_key}) ? $map->{$game_state_key} : null;
    }

    private static function getStateMap()
    {
        return self::getCache()->stateMap;
    }

    private function cacheState()
    {
        self::getStateMap()->{$this->getKey()} = $this;
        self::saveCache();
    }

    private static function generateKey()
    {
        $cache = self::getCache();
        return strval(++$cache->keyCounter);
    }

    private static function getCache()
    {
        if (!isset(self::$cache)) {
            if (file_exists(GameConstants::CACHE)) {
                $cache = fopen(GameConstants::CACHE, "r");
                $serial = fread($cache, filesize(GameConstants::CACHE));
                fclose($cache);
                self::$cache = unserialize($serial);
            } else {
                self::$cache = new \stdClass();
                self::$cache->keyCounter = 0;
                self::$cache->stateMap = new \stdClass();
                self::resetWords();
            }
        }
        return self::$cache;
    }

    private static function saveCache()
    {
        $serial = serialize(self::$cache);
        $cache = fopen(GameConstants::CACHE, "w");
        fwrite($cache, $serial);
        fclose($cache);
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getWord()
    {
        return $this->word;
    }

    public function getGuessCount()
    {
        return count($this->guessedLetters);
    }

    public function getRemainingGuesses()
    {
        return GameConstants::MAX_GUESSES - $this->getGuessCount();
    }

    /**
     * Gets the version of the target word with underscores for any un-guessed letters.
     */
    public function getWordMask()
    {
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
        return $this->previousState;
    }

    public function guessLetter($letter) : GameState
    {
        if ($this->isGameOver()) {
            return $this;
        }

        // trim any whitespace
        $letter = trim($letter);

        // only one letter allowed
        $letter = $letter[0];

        // normalize to all uppercase letters
        $letter = strtoupper($letter);

        // check if letter is valid
        if (!in_array($letter, range('A', 'Z'))) {
            return $this;
        }

        // check if letter has already been guessed
        if ($this->hasGuessedLetter($letter)) {
            return $this;
        }

        $next = $this->clone();

        // add new letter to beginning of array
        array_unshift($next->guessedLetters, $letter);

        // update the m_a_s_k
        $next->makeMask();

        $next->cacheState();

        return $next;
    }

    public function hasGuessedLetter($letter)
    {
        return in_array($letter, $this->guessedLetters);
    }

    public function guessWord($word_guess)
    {
        if (!$this->isGameOver()) {
            $copy = $this->clone();
            $copy->wordGuess = strtoupper($word_guess);
            $copy->saveCache();
            return $copy;
        }
        // game is already over. return the current state unchanged.
        return $this;
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
        return $this->getRemainingGuesses() <= 0 ||  (isset($this->wordGuess) && !$this->isGuessCorrect());
    }

    public function isGuessCorrect()
    {
        return $this->word == $this->wordGuess;
    }

    /**
     * Checks whether we've already guessed all the letters correctly.
     */
    public function allLettersGuessed()
    {
        return strpos($this->getWordMask(), GameConstants::SPACER) === false;
    }

    public static function hasMoreWords()
    {
        return !empty(self::getCache()->words);
    }

    /** Reset the list of words. */
    public static function resetWords()
    {
        $cache = self::getCache();
        $cache->words = GameConstants::WORDS;
        self::saveCache();
    }
}
