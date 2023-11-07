<?php

namespace EliaPc\CptManager\Pages;

use EliaPc\CptManager\Base\BaseController;
use EliaPc\CptManager\Api\SettingsApi;
use EliaPc\CptManager\Api\Callbacks\CPTCallback;

class Dashboard extends BaseController{
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
        $this->settings_api->AddPages($this->pages) -> withSubPage(esc_html__('Manage CPT' , 'cpt_plugin')) -> register();
        $this->settings_api->addSubPages($this->sub_pages) -> register();
    }

    public function setPages():void{
        $this->pages = array([
            'page_title' => esc_html__('CPT Manager' , 'cpt_plugin'),
            'menu_title' => esc_html__('CPT Manager' , 'cpt_plugin'),
            'capability' => 'manage_options',
            'menu_slug' => 'cpt_manager',
            'callback' => array($this->CPT_callback , 'cptManagerPage'),
            'icon_url' => 'dashicons-text-page',
            'position' => 25
        ] , [
            'page_title' => 'مدیریت دوم',
            'menu_title' => 'مدیریت دوم',
            'capability' => 'manage_options',
            'menu_slug' => 'cpt_manager_2',
            'callback' => array($this->CPT_callback , 'cptManagerPage2'),
            'icon_url' => 'dashicons-screenoptions',
            'position' => 26
        ]);

        $this->sub_pages = array([
            'parent_slug' => 'cpt_manager',
            'page_title' => esc_html__('CPT Manager U1' , 'cpt_plugin'),
            'menu_title' => esc_html__('CPT Manager U1' , 'cpt_plugin'),
            'capability' => 'manage_options',
            'menu_slug' => 'cpt_manager_u1',
            'callback' => array($this->CPT_callback , 'cptManagerPageU1')
        ] , [
            'parent_slug' => 'cpt_manager_2',
            'page_title' => 'مدیریت دوم اول',
            'menu_title' => 'مدیریت دوم اول',
            'capability' => 'manage_options',
            'menu_slug' => 'cpt_manager_21',
            'callback' => array($this->CPT_callback , 'cptManagerPage21')
        ]);
    }


    public function setSettings():void{
        $args = array(
            'option_group' => 'cpt_manager_settings',
            'option_name' => 'cpt_manager_plugin_settings',
            'callback' => array($this->CPT_callback , 'cptSanitize')
        );
        $this->settings_api->setSettings($args);
    }


    public function setSections():void{
        $args = array(
            [
                'id' => 'cpt_manager_admin_index',
                'title' => esc_html__('Settings' , 'cpt_plugin'),
                'callback' => array($this->CPT_callback , 'cptManagerAdminSection'),
                'page' => 'cpt_manager'
            ]
        );
        $this->settings_api->setSections($args);
    }

    public function setFields():void{
        $args = array(
            [
                'id' => 'post_type',
                'title' => esc_html__('Post Type ID' , 'cpt_plugin'),
                'callback' => array($this->CPT_callback , 'inputField'),
                'page' => 'cpt_manager',
                'section' => 'cpt_manager_admin_index',
                'args' => array(
                    'name' => 'post_type',
                    'option_name' => 'cpt_manager_plugin_settings',
                    'placeholder' => esc_html__('Type your post type id' , 'cpt_plugin')
                )
            ],[
                'id' => 'name',
                'title' => esc_html__('Custom post type plural name' , 'cpt_plugin'),
                'callback' => array($this->CPT_callback , 'inputField'),
                'page' => 'cpt_manager',
                'section' => 'cpt_manager_admin_index',
                'args' => array(
                    'name' => 'name',
                    'option_name' => 'cpt_manager_plugin_settings',
                    'placeholder' => esc_html__('Type your post type plural name' , 'cpt_plugin')
                )
            ],[
                'id' => 'singular_name',
                'title' => esc_html__('Post Type singular_name' , 'cpt_plugin'),
                'callback' => array($this->CPT_callback , 'inputField'),
                'page' => 'cpt_manager',
                'section' => 'cpt_manager_admin_index',
                'args' => array(
                    'name' => 'singular_name',
                    'option_name' => 'cpt_manager_plugin_settings',
                    'placeholder' => esc_html__('Type your post type singular_name' , 'cpt_plugin')
                )
            ],[
                'id' => 'menu_name',
                'title' => esc_html__('Post Type menu_name' , 'cpt_plugin'),
                'callback' => array($this->CPT_callback , 'inputField'),
                'page' => 'cpt_manager',
                'section' => 'cpt_manager_admin_index',
                'args' => array(
                    'name' => 'menu_name',
                    'option_name' => 'cpt_manager_plugin_settings',
                    'placeholder' => esc_html__('Type your post type menu_name' , 'cpt_plugin')
                )
            ],[
                'id' => 'menu_icon',
                'title' => esc_html__('Post Type menu_icon' , 'cpt_plugin'),
                'callback' => array($this->CPT_callback , 'inputField'),
                'page' => 'cpt_manager',
                'section' => 'cpt_manager_admin_index',
                'args' => array(
                    'name' => 'menu_icon',
                    'option_name' => 'cpt_manager_plugin_settings',
                    'placeholder' => esc_html__('Type your post type menu_icon' , 'cpt_plugin')
                )
            ],[
                'id' => 'menu_position',
                'title' => esc_html__('Post Type menu_position' , 'cpt_plugin'),
                'callback' => array($this->CPT_callback , 'inputField'),
                'page' => 'cpt_manager',
                'section' => 'cpt_manager_admin_index',
                'args' => array(
                    'name' => 'menu_position',
                    'option_name' => 'cpt_manager_plugin_settings',
                    'placeholder' => esc_html__('Type your post type menu_position' , 'cpt_plugin')
                )
            ],[
                'id' => 'public',
                'title' => esc_html__('Make the post type public' , 'cpt_plugin'),
                'callback' => array($this->CPT_callback , 'checkboxField'),
                'page' => 'cpt_manager',
                'section' => 'cpt_manager_admin_index',
                'args' => array(
                    'name' => 'public',
                    'option_name' => 'cpt_manager_plugin_settings',
                )
            ],[
                'id' => 'has_archive',
                'title' => esc_html__('Has archive', 'cpt_plugin'),
                'callback' => array($this->CPT_callback, 'checkboxField'),
                'page' => 'cpt_manager',
                'section' => 'cpt_manager_admin_index',
                'args' => array(
                    'name' => 'has_archive',
                    'option_name' => 'cpt_manager_plugin_settings'
                ),
            ],
            array(
                'id' => 'show_in_admin_bar',
                'title' => esc_html__('Show in Admin Bar', 'cpt_plugin'),
                'callback' => array($this->CPT_callback, 'checkboxField'),
                'page' => 'cpt_manager',
                'section' => 'cpt_manager_admin_index',
                'args' => array(
                    'name' => 'show_in_admin_bar',
                    'option_name' => 'cpt_manager_plugin_settings',
                ),
            ),
            array(
                'id' => 'show_in_nav_menus',
                'title' => esc_html__('Show in Nav Menus', 'cpt_plugin'),
                'callback' => array($this->CPT_callback, 'checkboxField'),
                'page' => 'cpt_manager',
                'section' => 'cpt_manager_admin_index',
                'args' => array(
                    'name' => 'show_in_nav_menus',
                    'option_name' => 'cpt_manager_plugin_settings',
                ),
            ),
            array(
                'id' => 'hierarchical',
                'title' => esc_html__('Is Hierarchical', 'cpt_plugin'),
                'callback' => array($this->CPT_callback, 'checkboxField'),
                'page' => 'cpt_manager',
                'section' => 'cpt_manager_admin_index',
                'args' => array(
                    'name' => 'hierarchical',
                    'option_name' => 'cpt_manager_plugin_settings',
                ),
            ),
            array(
                'id' => 'show_ui',
                'title' => esc_html__('Show UI', 'cpt_plugin'),
                'callback' => array($this->CPT_callback, 'checkboxField'),
                'page' => 'cpt_manager',
                'section' => 'cpt_manager_admin_index',
                'args' => array(
                    'name' => 'show_ui',
                    'option_name' => 'cpt_manager_plugin_settings',
                ),
            ),
            array(
                'id' => 'show_in_menu',
                'title' => esc_html__('Show in Menu', 'cpt_plugin'),
                'callback' => array($this->CPT_callback, 'checkboxField'),
                'page' => 'cpt_manager',
                'section' => 'cpt_manager_admin_index',
                'args' => array(
                    'name' => 'show_in_menu',
                    'option_name' => 'cpt_manager_plugin_settings',
                ),
            ),
            array(
                'id' => 'can_export',
                'title' => esc_html__('Can Export', 'cpt_plugin'),
                'callback' => array($this->CPT_callback, 'checkboxField'),
                'page' => 'cpt_manager',
                'section' => 'cpt_manager_admin_index',
                'args' => array(
                    'name' => 'can_export',
                    'option_name' => 'cpt_manager_plugin_settings',
                ),
            ),
            array(
                'id' => 'exclude_from_search',
                'title' => esc_html__('Exclude From Search', 'cpt_plugin'),
                'callback' => array($this->CPT_callback, 'checkboxField'),
                'page' => 'cpt_manager',
                'section' => 'cpt_manager_admin_index',
                'args' => array(
                    'name' => 'exclude_from_search',
                    'option_name' => 'cpt_manager_plugin_settings',
                ),
            ),
            array(
                'id' => 'publicly_queryable',
                'title' => esc_html__('Publicly Queryable', 'cpt_plugin'),
                'callback' => array($this->CPT_callback, 'checkboxField'),
                'page' => 'cpt_manager',
                'section' => 'cpt_manager_admin_index',
                'args' => array(
                    'name' => 'publicly_queryable',
                    'option_name' => 'cpt_manager_plugin_settings',
                ),
            )
        );
        $this->settings_api->setFields($args);
    }
}















