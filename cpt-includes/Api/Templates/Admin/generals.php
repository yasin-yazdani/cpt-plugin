<?php

namespace EliaPc\CptManager\Api\Templates\Admin;

use EliaPc\CptManager\Base\BaseController;

class generals extends BaseController {
    public function getHeader(): string
    {
        return '<div class="my_cpt_settings_wrapper">';
    }

    public function getFooter(): string
    {
        return '</div>';
    }
}
