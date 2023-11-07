<?php

namespace EliaPc\CptManager\Base;

class Activate {
    public static function activate_function(){
        flush_rewrite_rules();
        if (!get_option('cpt_manager_options')){
            update_option('cpt_manager_options' , serialize(array()));
        }
        elseif (get_option('cpt_manager_options')){
            update_option('cpt_manager_options' , serialize(array(
                'name' => 'yasin',
                'lastname' => 'yazdani'
            )));
        }
    }
}
