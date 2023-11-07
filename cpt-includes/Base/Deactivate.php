<?php

namespace EliaPc\CptManager\Base;

class Deactivate {
    public static function deactivate_function(){
        flush_rewrite_rules();

    }
}