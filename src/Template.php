<?php

namespace App;

class Template
{
    private $templateFile;

    public function __construct($template_file)
    {
        $this->templateFile = $template_file;
    }

    public function render($data) {
        ob_start();

        if (!file_exists($this->templateFile)) {
            error_log("Template file not found: " . $this->templateFile);
            return;
        }

        // extract values so they can be referenced by the included template
        if (is_array($data) ){
            extract($data);
        }

        include $this->templateFile;

        // return contents of the output buffer and delete contents of buffer
        return ob_get_clean();
    }
}