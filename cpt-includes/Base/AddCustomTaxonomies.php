<?php

namespace EliaPc\CptManager\Base;

class AddCustomTaxonomies extends BaseController{
    public array $custom_taxonomy = array();

    public function register(): void {
        $this->storeCustomTaxonomies();
        add_action( 'init', array( $this, 'registerTAX' ) );
    }

    public function storeCustomTaxonomies()
    {
        if(!get_option('tax_manager_plugin_settings')){
            return;
        }

        $options = get_option( 'tax_manager_plugin_settings' );

        $menu_pos=isset($option['menu_position']) ? ((trim($option['menu_position']) !== '') ? ((filter_var($option['menu_position'],FILTER_VALIDATE_INT) !== false) ? $option['menu_position'] : 5) :5) : 5;


        foreach ( $options as $option ){
            $this->custom_taxonomy[] = array(
                'taxonomy'             => $option['taxonomy'],
                'name'                  => $option['name'],
                'singular_name'         => $option['singular_name'],
                'menu_name'             => $option['menu_name'],
                'name_admin_bar'        => $option['singular_name'],
                'archives'              => $option['singular_name'] . ' Archives',
                'attributes'            => $option['singular_name'] . ' Attributes',
                'parent_item_colon'     => 'Parent ' . $option['singular_name'],
                'all_items'             => 'All ' . $option['name'],
                'add_new_item'          => 'Add New ' . $option['singular_name'],
                'add_new'               => 'Add New',
                'new_item'              => 'New ' . $option['singular_name'],
                'edit_item'             => 'Edit ' . $option['singular_name'],
                'update_item'           => 'Update ' . $option['singular_name'],
                'view_item'             => 'View ' . $option['singular_name'],
                'view_items'            => 'View ' . $option['name'],
                'search_items'          => 'Search ' . $option['name'],
                'not_found'             => 'هیچ ' . $option['singular_name'] . ' یافت نشد',
                'not_found_in_trash'    => 'هیچ ' . $option['singular_name'] . ' در سطل زباله یافت نشد',
                'featured_image'        => 'تصویر شاخص',
                'set_featured_image'    => 'ایجاد تصویر شاخص',
                'remove_featured_image' => 'حذف تصویر شاخص',
                'use_featured_image'    => 'استفاده از تصویر شاخص',
                'insert_into_item'      => 'Insert into' . $option['singular_name'],
                'uploaded_to_this_item' => 'Upload to this ' . $option['singular_name'],
                'items_list'            => $option['name'] . ' List',
                'items_list_navigation' => $option['name'] . ' List Navigation',
                'filter_items_list'     => 'Filter' . $option['name'] . ' List',
                'label'                 => $option['singular_name'],
                'description'           => $option['name'] . 'Custom Post Type',
                'hierarchical'          => $option['hierarchical'],
                'public'                => $option['public'],
                'show_ui'               => $option['show_ui'],
                'show_in_menu'          => $option['show_in_menu'],
                'menu_position'         => intval($menu_pos),
                'show_in_admin_bar'     => $option['show_in_admin_bar'],
                'show_in_nav_menus'     => $option['show_in_nav_menus'],
                'can_export'            => $option['can_export'],
                'has_archive'           => $option['has_archive'],
                'exclude_from_search'   => $option['exclude_from_search'],
                'publicly_queryable'    => $option['publicly_queryable'],
                'capability_type'       => 'post',
                'menu_icon'             => (isset($option['menu_icon']) ? ((trim($option['menu_icon']) === '') ? false : $option['menu_icon']) : false),
            );
        }
    }

    public function registerTAX():void{
        foreach ($this->custom_taxonomy as $taxonomy){
            register_taxonomy( $taxonomy['taxonomy'],
                array(
                    'labels' => array(
                        'name'                  => $taxonomy['name'],
                        'singular_name'         => $taxonomy['singular_name'],
                        'menu_name'             => $taxonomy['menu_name'],
                        'name_admin_bar'        => $taxonomy['name_admin_bar'],
                        'archives'              => $taxonomy['archives'],
                        'attributes'            => $taxonomy['attributes'],
                        'parent_item_colon'     => $taxonomy['parent_item_colon'],
                        'all_items'             => $taxonomy['all_items'],
                        'add_new_item'          => $taxonomy['add_new_item'],
                        'add_new'               => $taxonomy['add_new'],
                        'new_item'              => $taxonomy['new_item'],
                        'edit_item'             => $taxonomy['edit_item'],
                        'update_item'           => $taxonomy['update_item'],
                        'view_item'             => $taxonomy['view_item'],
                        'view_items'            => $taxonomy['view_items'],
                        'search_items'          => $taxonomy['search_items'],
                        'not_found'             => $taxonomy['not_found'],
                        'not_found_in_trash'    => $taxonomy['not_found_in_trash'],
                        'featured_image'        => $taxonomy['featured_image'],
                        'set_featured_image'    => $taxonomy['set_featured_image'],
                        'remove_featured_image' => $taxonomy['remove_featured_image'],
                        'use_featured_image'    => $taxonomy['use_featured_image'],
                        'insert_into_item'      => $taxonomy['insert_into_item'],
                        'uploaded_to_this_item' => $taxonomy['uploaded_to_this_item'],
                        'items_list'            => $taxonomy['items_list'],
                        'items_list_navigation' => $taxonomy['items_list_navigation'],
                        'filter_items_list'     => $taxonomy['filter_items_list']
                    ),
                    'label'                     => $taxonomy['label'],
                    'description'               => $taxonomy['description'],
                    'hierarchical'              => $taxonomy['hierarchical'],
                    'public'                    => $taxonomy['public'],
                    'show_ui'                   => $taxonomy['show_ui'],
                    'show_in_menu'              => $taxonomy['show_in_menu'],
                    'menu_position'             => $taxonomy['menu_position'],
                    'show_in_admin_bar'         => $taxonomy['show_in_admin_bar'],
                    'show_in_nav_menus'         => $taxonomy['show_in_nav_menus'],
                    'can_export'                => $taxonomy['can_export'],
                    'has_archive'               => $taxonomy['has_archive'],
                    'exclude_from_search'       => $taxonomy['exclude_from_search'],
                    'publicly_queryable'        => $taxonomy['publicly_queryable'],
                    'capability_type'           => $taxonomy['capability_type'],
                    'menu_icon'                 => $taxonomy['menu_icon']
                )
            );
        }
    }
}