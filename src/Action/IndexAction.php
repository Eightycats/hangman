<?php

namespace App\Action;

class IndexAction extends TemplateAction
{
    protected function invoke($args)
    {
        // TODO nothing to do currently. just show the index page.
    }

    protected function getTemplate()
    {
        return 'index';
    }
}
