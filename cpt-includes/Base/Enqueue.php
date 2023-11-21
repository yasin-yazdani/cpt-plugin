<?php

namespace EliaPc\CptManager\Base;


class Enqueue extends BaseController {

    public function register():void{
        add_action('admin_enqueue_scripts' , array($this , 'cpt_manager_admin_scripts'));
    }

    public function cpt_manager_admin_scripts():void{
        global $page_hook;
        if (strpos($page_hook , 'cpt_manager') || strpos($page_hook , 'tax_manager')){
            wp_enqueue_style('admin.style',$this->plugin_url . 'assets/css/admin.style.min.css',array() , $this->plugin_version);
            wp_enqueue_style('bootstrap.style',$this->plugin_url . 'assets/css/bootstrap.min.css',array() , $this->plugin_version);
            wp_enqueue_style('bootstrap.rtl.style',$this->plugin_url . 'assets/css/bootstrap.rtl.min.css',array() , $this->plugin_version);
            wp_enqueue_script('admin.script',$this->plugin_url . 'assets/js/admin.script.min.js',array(), $this->plugin_version ,true);
            wp_enqueue_script('bootstrap.script',$this->plugin_url . 'assets/js/bootstrap.bundle.min.js',array('jquery'), $this->plugin_version ,true);
        }
    }
}
