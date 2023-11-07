<?php

namespace EliaPc\CptManager\Base;

class BaseController{
    public string $plugin_dir;
    public string $plugin_url;
    public string $plugin;
    public bool $is_plugin_active;
    public string $plugin_version;

    public function __construct(){
        $this->plugin_url = plugin_dir_url(dirname(__FILE__ , 2));
        $this->plugin_dir = plugin_dir_path(dirname(__FILE__ , 2));
        $this->plugin = plugin_basename(dirname(__FILE__ , 3)).'cpt-manager.php';
        //$this->is_plugin_active = is_plugin_active($this->plugin);
        $this->plugin_version = '1.0.0';
    }
}
