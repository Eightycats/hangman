<!DOCTYPE HTML>

<?php
        $game_exists = !empty($game_state);

        $game_over = false;
        $win = false;
        $lose = false;
        $guess_count = 0;
        $mask = "";

        if ($game_exists) {
            $key = $game_state->getKey();
            $game_over = $game_state->isGameOver();
            $win = $game_state->isWin();
            $lose = $game_state->isLose();
            $guess_count =  $game_state->getGuessCount();
            // show them the whole word if the game is over
            $mask = $game_over ? $game_state->getWord() : $game_state->getWordMask();
        }

        $image = '/rsrc/img/' . $guess_count . '.png';
?>

<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Bad Rabbit Hangman Challenge</title>
    <link rel="stylesheet" type="text/css" href="/rsrc/css/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="container">
    <div class="title_container">
        <h1 class="title">Bad Rabbit Hangman Challenge</h1>
    </div>

    <div class="game_container">

    <!-- messages -->
    <div class="message_container">
        <p class="message">
            <?php
                if ($game_exists) {
                    if ($win) {
                        echo "YOU WIN!";
                    } else if ($lose) {
                        echo "Sorry, You Lose.";
                    }
                }
            ?>
        </p>
        <p class="message error">
            <?php
                if (!empty($error_message)) {
                    echo $error_message;
                }
            ?>
        </p>
    </div>

    <!-- hangman image -->
    <div class="image_container">
        <img src="<?php echo $image; ?>">
        <!-- guesses left -->
        <p class="guess_label">
            <?php if ($game_exists) { echo "Guesses Left: " . $game_state->getRemainingGuesses(); } ?>
        </p>
    </div>

    <!-- TODO GUESS FORM -->

    <?php
        if ($game_exists) {
     ?>
        <!-- w_or_d m_as_k -->
        <div class="mask_container">
            <?php
                for($i = 0; $i < strlen($mask); $i++) {
                    echo "<span class=\"mask_box\">$mask[$i]</span>";
                }
            ?>
        </div>

        <!-- alphabet -->
        <div class="letter_container">
            <?php
                if (!$game_over) {
                    foreach (range('A', 'Z') as $letter) {
                        $uri = '/guess/' . $key . '/' . $letter;
                        echo "<span class=\"letter_box\">";
                        if ($game_state->hasGuessedLetter($letter)) {
                            echo "<span href=\"$uri\" class=\"letter used_letter\">$letter</span>";
                        } else {
                            echo "<a href=\"$uri\" class=\"btn letter\">$letter</a>";
                        }
                        echo "</span>";
                    }
                }
            ?>
        </div>
    <?php
        }

        if (!$game_exists || $game_over) {
    ?>
            <div class="new_container">
                <a href="/new" class="btn new_game">New Game</a>
            </div>
    <?php
        }
    ?>

    </div>

</div>
</body>
</html>

