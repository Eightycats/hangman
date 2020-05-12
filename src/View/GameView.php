<?php

namespace App\View;

class GameView
{
    private $templateFile;

    public function __construct($template_file)
    {
        $this->templateFile = $template_file;
    }

    public function render($game_state, $error_message = null) {
        if (!file_exists($this->templateFile)) {
            throw new \Exception("Template file not found: " . $this->templateFile);
        }

        // start writing to an output buffer
        ob_start();

        // read and populate the template
        include $this->templateFile;

        // return contents of the output buffer and delete contents of buffer
        return ob_get_clean();
    }
}