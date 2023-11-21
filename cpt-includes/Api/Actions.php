<?php

namespace EliaPc\CptManager\Api;

use EliaPc\CptManager\Api\Templates\Admin\post_type_settings;
use EliaPc\CptManager\Api\Templates\Admin\taxonomy_settings;

class Actions {
    public post_type_settings $post_type_settings;
    public taxonomy_settings $taxonomy_settings;
    public function register():void{
        $this->post_type_settings = new post_type_settings();
        $this->taxonomy_settings = new taxonomy_settings();
        add_action('get_post_type_settings_admin_form' , array($this->post_type_settings , 'show'));
        add_action('get_taxonomy_settings_admin_form' , array($this->taxonomy_settings , 'show'));
    }
}
