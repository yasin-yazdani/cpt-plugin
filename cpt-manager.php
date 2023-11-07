<?php
/**
 * Plugin Name
 *
 * @package           Cpt-Manager
 * @author            Yasin Yazdani
 * @copyright         2023 By Yasin
 * @license           GPL-3.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Custom Post Type Manager
 * Plugin URI:        https://example.com/cpt-manager
 * Description:       Custom Post Type Manager plugin for WordPress
 * Version:           1.0.0
 * Requires at least: 5.6
 * Requires PHP:      7.4
 * Author:            Yasin Yazdani
 * Author URI:        https://example.com
 * Text Domain:       cpt_plugin
 * Domain Path:       /assets/lang
 * License:           GPL v3 or later
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Update URI:        https://example.com/my-plugin/
 */

if (file_exists(dirname(__FILE__).'/vendor/autoload.php')){
    require_once dirname(__FILE__).'/vendor/autoload.php';
}

if (class_exists("EliaPc\CptManager\CptManagerInit")){
    EliaPc\CptManager\CptManagerInit::register_services();
}

register_activation_hook(__FILE__ , 'cpt_manager_activate_hook');
function cpt_manager_activate_hook(){
    if (class_exists("EliaPc\CptManager\Base\Activate")){
        EliaPc\CptManager\Base\Activate::activate_function();
    }
}

register_deactivation_hook(__FILE__ , 'cpt_manager_deactivate_hook');
function cpt_manager_deactivate_hook(){
    if (class_exists("EliaPc\CptManager\Base\Deactivate")){
        EliaPc\CptManager\Base\Deactivate::deactivate_function();
    }
}







