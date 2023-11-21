<?php

namespace EliaPc\CptManager\Pages;

use EliaPc\CptManager\Base\BaseController;
use EliaPc\CptManager\Api\SettingsApi;
use EliaPc\CptManager\Api\Callbacks\CPTCallback;

class TaxDashboard extends BaseController {
    public SettingsApi $settings_api;
    public CPTCallback $CPT_callback;
    public array $pages = array();
    public array $sub_pages = array();


    public function register():void{
        $this->settings_api = new SettingsApi();
        $this->CPT_callback = new CPTCallback();
        $this->setPages();
        $this->setSettings();
        $this->setSections();
        $this->setFields();
        //$this->settings_api->AddPages($this->pages) -> withSubPage(esc_html__('Manage CPT' , 'cpt_plugin')) -> register();
        $this->settings_api->addSubPages($this->sub_pages) -> register();
    }

    public function setPages():void{
        $this->sub_pages = array(
            [
                'parent_slug' => 'cpt_manager',
                'page_title' => esc_html__('TAX Manager' , 'cpt_plugin'),
                'menu_title' => esc_html__('TAX Manager' , 'cpt_plugin'),
                'capability' => 'manage_options',
                'menu_slug' => 'tax_manager',
                'callback' => array($this->CPT_callback , 'taxManagerPage')
            ]
        );
    }


    public function setSettings():void{
        $args = array(
            'option_group' => 'tax_manager_settings',
            'option_name' => 'tax_manager_plugin_settings',
            'callback' => array($this->CPT_callback , 'taxSanitize')
        );
        $this->settings_api->setSettings($args);
    }


    public function setSections():void{
        $args = array(
            [
                'id' => 'tax_manager_admin_index',
                'title' => esc_html__('Tax Settings' , 'cpt_plugin'),
                'callback' => array($this->CPT_callback , 'taxManagerAdminSection'),
                'page' => 'tax_manager'
            ]
        );
        $this->settings_api->setSections($args);
    }

    public function setFields():void{
        $args = array(
            [
                'id' => 'taxonomy',
                'title' => esc_html__('taxonomy ID' , 'cpt_plugin'),
                'callback' => array($this->CPT_callback , 'inputField'),
                'page' => 'tax_manager',
                'section' => 'tax_manager_admin_index',
                'args' => array(
                    'name' => 'taxonomy',
                    'option_name' => 'tax_manager_plugin_settings',
                    'placeholder' => esc_html__('Type your taxonomy id' , 'cpt_plugin')
                )
            ],[
                'id' => 'name',
                'title' => esc_html__('Custom tax plural name' , 'cpt_plugin'),
                'callback' => array($this->CPT_callback , 'inputField'),
                'page' => 'tax_manager',
                'section' => 'tax_manager_admin_index',
                'args' => array(
                    'name' => 'name',
                    'option_name' => 'tax_manager_plugin_settings',
                    'placeholder' => esc_html__('Type your taxonomy plural name' , 'cpt_plugin')
                )
            ],[
                'id' => 'singular_name',
                'title' => esc_html__('taxonomy singular_name' , 'cpt_plugin'),
                'callback' => array($this->CPT_callback , 'inputField'),
                'page' => 'tax_manager',
                'section' => 'tax_manager_admin_index',
                'args' => array(
                    'name' => 'singular_name',
                    'option_name' => 'tax_manager_plugin_settings',
                    'placeholder' => esc_html__('Type your taxonomy singular_name' , 'cpt_plugin')
                )
            ],[
                'id' => 'menu_name',
                'title' => esc_html__('taxonomy menu_name' , 'cpt_plugin'),
                'callback' => array($this->CPT_callback , 'inputField'),
                'page' => 'tax_manager',
                'section' => 'tax_manager_admin_index',
                'args' => array(
                    'name' => 'menu_name',
                    'option_name' => 'tax_manager_plugin_settings',
                    'placeholder' => esc_html__('Type your taxonomy menu_name' , 'cpt_plugin')
                )
            ],[
                'id' => 'menu_icon',
                'title' => esc_html__('taxonomy menu_icon' , 'cpt_plugin'),
                'callback' => array($this->CPT_callback , 'inputField'),
                'page' => 'tax_manager',
                'section' => 'tax_manager_admin_index',
                'args' => array(
                    'name' => 'menu_icon',
                    'option_name' => 'tax_manager_plugin_settings',
                    'placeholder' => esc_html__('Type your taxonomy menu_icon' , 'cpt_plugin')
                )
            ],[
                'id' => 'menu_position',
                'title' => esc_html__('taxonomy menu_position' , 'cpt_plugin'),
                'callback' => array($this->CPT_callback , 'inputField'),
                'page' => 'tax_manager',
                'section' => 'tax_manager_admin_index',
                'args' => array(
                    'name' => 'menu_position',
                    'option_name' => 'tax_manager_plugin_settings',
                    'placeholder' => esc_html__('Type your taxonomy menu_position' , 'cpt_plugin')
                )
            ],[
                'id' => 'public',
                'title' => esc_html__('Make the taxonomy public' , 'cpt_plugin'),
                'callback' => array($this->CPT_callback , 'checkboxField'),
                'page' => 'tax_manager',
                'section' => 'tax_manager_admin_index',
                'args' => array(
                    'name' => 'public',
                    'option_name' => 'tax_manager_plugin_settings',
                )
            ],[
                'id' => 'has_archive',
                'title' => esc_html__('Has archive', 'cpt_plugin'),
                'callback' => array($this->CPT_callback, 'checkboxField'),
                'page' => 'tax_manager',
                'section' => 'tax_manager_admin_index',
                'args' => array(
                    'name' => 'has_archive',
                    'option_name' => 'tax_manager_plugin_settings'
                ),
            ],
            array(
                'id' => 'show_in_admin_bar',
                'title' => esc_html__('Show in Admin Bar', 'cpt_plugin'),
                'callback' => array($this->CPT_callback, 'checkboxField'),
                'page' => 'tax_manager',
                'section' => 'tax_manager_admin_index',
                'args' => array(
                    'name' => 'show_in_admin_bar',
                    'option_name' => 'tax_manager_plugin_settings',
                ),
            ),
            array(
                'id' => 'show_in_nav_menus',
                'title' => esc_html__('Show in Nav Menus', 'cpt_plugin'),
                'callback' => array($this->CPT_callback, 'checkboxField'),
                'page' => 'tax_manager',
                'section' => 'tax_manager_admin_index',
                'args' => array(
                    'name' => 'show_in_nav_menus',
                    'option_name' => 'tax_manager_plugin_settings',
                ),
            ),
            array(
                'id' => 'hierarchical',
                'title' => esc_html__('Is Hierarchical', 'cpt_plugin'),
                'callback' => array($this->CPT_callback, 'checkboxField'),
                'page' => 'tax_manager',
                'section' => 'tax_manager_admin_index',
                'args' => array(
                    'name' => 'hierarchical',
                    'option_name' => 'tax_manager_plugin_settings',
                ),
            ),
            array(
                'id' => 'show_ui',
                'title' => esc_html__('Show UI', 'cpt_plugin'),
                'callback' => array($this->CPT_callback, 'checkboxField'),
                'page' => 'tax_manager',
                'section' => 'tax_manager_admin_index',
                'args' => array(
                    'name' => 'show_ui',
                    'option_name' => 'tax_manager_plugin_settings',
                ),
            ),
            array(
                'id' => 'show_in_menu',
                'title' => esc_html__('Show in Menu', 'cpt_plugin'),
                'callback' => array($this->CPT_callback, 'checkboxField'),
                'page' => 'tax_manager',
                'section' => 'tax_manager_admin_index',
                'args' => array(
                    'name' => 'show_in_menu',
                    'option_name' => 'tax_manager_plugin_settings',
                ),
            ),
            array(
                'id' => 'can_export',
                'title' => esc_html__('Can Export', 'cpt_plugin'),
                'callback' => array($this->CPT_callback, 'checkboxField'),
                'page' => 'tax_manager',
                'section' => 'tax_manager_admin_index',
                'args' => array(
                    'name' => 'can_export',
                    'option_name' => 'tax_manager_plugin_settings',
                ),
            ),
            array(
                'id' => 'exclude_from_search',
                'title' => esc_html__('Exclude From Search', 'cpt_plugin'),
                'callback' => array($this->CPT_callback, 'checkboxField'),
                'page' => 'tax_manager',
                'section' => 'tax_manager_admin_index',
                'args' => array(
                    'name' => 'exclude_from_search',
                    'option_name' => 'tax_manager_plugin_settings',
                ),
            ),
            array(
                'id' => 'publicly_queryable',
                'title' => esc_html__('Publicly Queryable', 'cpt_plugin'),
                'callback' => array($this->CPT_callback, 'checkboxField'),
                'page' => 'tax_manager',
                'section' => 'tax_manager_admin_index',
                'args' => array(
                    'name' => 'publicly_queryable',
                    'option_name' => 'tax_manager_plugin_settings',
                ),
            )
        );
        $this->settings_api->setFields($args);
    }
}