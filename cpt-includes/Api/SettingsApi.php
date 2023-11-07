<?php
/**
 * @package           Cpt-Manager
 */

namespace EliaPc\CptManager\Api;

if (!defined('ABSPATH')) die();

class SettingsApi
{
    public array $admin_pages = array();
    public array $admin_subpages = array();
    public array $settings = array();
    public array $sections = array();
    public array $fields = array();

    /**
     * Register settings service api, this api register settings pages to the admin panel.
     *
     * @param array|null $data
     * @return void
     */
    public function register(array $data=null): void
    {
        if(!empty($this->admin_pages) || !empty($this->admin_subpages)){
            add_action('admin_menu',array($this,'addAdminMenu'), 25 );
        }
        if(!empty($this->settings)){
            add_action('admin_init',array($this,'registerCustomFields'));
        }
    }

    /**
     * Add admin panel pages to the admin_pages array
     *
     * @param array $pages
     * @return $this
     */
    public function AddPages(array $pages)
    {
        $this->admin_pages = $pages;
        return $this;
    }

    /**
     * Add main subpage of main dashboard menu if it has any
     *
     * @param string|null $title
     * @return $this
     */
    public function withSubPage(string $title = null)
    {
        if(empty($this->admin_pages)){
            return $this;
        }
        $admin_page = $this->admin_pages[0];

        $subpage = array(
            array(
                'parent_slug' => $admin_page['menu_slug'],
                'page_title'  => $admin_page['menu_title'],
                'menu_title'  => (trim($title)) ? trim($title) : $admin_page['menu_title'],
                'capability'  => $admin_page['capability'],
                'menu_slug' => $admin_page['menu_slug'],
                'callback'  => $admin_page['callback'],
            ),
        );

        $this->admin_subpages = $subpage;

        return $this;
    }

    /**
     * Add other subpages to the admin_subpages array other than the main subpage
     *
     * @param array $pages
     * @return $this
     */
    public function addSubPages(array $pages)
    {
        $this->admin_subpages = array_merge($this->admin_subpages,$pages);
        return $this;
    }

    /**
     * Add menus and submenus with related pages to the admin panel
     *
     * @return void
     */
    public function addAdminMenu(): void
    {
        foreach ($this->admin_pages as $page){
            add_menu_page($page['page_title'],$page['menu_title'],$page['capability'],$page['menu_slug'],$page['callback'],$page['icon_url'],$page['position']);
        }
        foreach ($this->admin_subpages as $page){
            add_submenu_page( $page['parent_slug'], $page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'], $page['callback'] );
        }
    }

    /**
     * Set settings array of menu items for custom fields
     *
     * @param array $settings
     * @return $this
     */
    public function setSettings(array $settings)
    {
        $this->settings = $settings;
        return $this;
    }

    /**
     * Set sections array of custom fields for related settings
     *
     * @param array $sections
     * @return $this
     */
    public function setSections(array $sections)
    {
        $this->sections = $sections;
        return $this;
    }

    /**
     * Set custom fields array for related settings and sections
     *
     * @param array $fields
     * @return $this
     */
    public function setFields(array $fields)
    {
        $this->fields = $fields;
        return $this;
    }

    /**
     * Register custom fields added for related settings and sections
     *
     * @return void
     */
    public function registerCustomFields(): void
    {
        register_setting($this->settings['option_group'],$this->settings['option_name'],(isset($this->settings['callback']) ? $this->settings['callback']:''));
        foreach ($this->sections as $section){
            add_settings_section($section['id'], $section['title'],(isset($section['callback']) ? $section['callback']:''),$section['page']);
        }
        foreach ($this->fields as $field){
            add_settings_field($field['id'], $field['title'],(isset($field['callback']) ? $field['callback']:''),$field['page'],$field['section'],(isset($field['args']) ? $field['args'] : ''));
        }
    }

}