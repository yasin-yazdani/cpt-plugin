<?php

namespace EliaPc\CptManager\Base;

class AddCustomPostTypes extends BaseController{
    public array $custom_post_type = array();

    public function register(): void {
        $this->storeCustomPostTypes();
        add_action( 'init', array( $this, 'registerCPT' ) );
    }

    public function storeCustomPostTypes()
    {
        if(!get_option('cpt_manager_plugin_settings')){
            return;
        }

        $options = get_option( 'cpt_manager_plugin_settings' );

        $menu_pos=isset($option['menu_position']) ? ((trim($option['menu_position']) !== '') ? ((filter_var($option['menu_position'],FILTER_VALIDATE_INT) !== false) ? $option['menu_position'] : 5) :5) : 5;


        foreach ( $options as $option ){
            $this->custom_post_type[] = array(
                'post_type'             => $option['post_type'],
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

    public function registerCPT():void{
        foreach ($this->custom_post_type as $post_type){
            register_post_type( $post_type['post_type'],
                array(
                    'labels' => array(
                        'name'                  => $post_type['name'],
                        'singular_name'         => $post_type['singular_name'],
                        'menu_name'             => $post_type['menu_name'],
                        'name_admin_bar'        => $post_type['name_admin_bar'],
                        'archives'              => $post_type['archives'],
                        'attributes'            => $post_type['attributes'],
                        'parent_item_colon'     => $post_type['parent_item_colon'],
                        'all_items'             => $post_type['all_items'],
                        'add_new_item'          => $post_type['add_new_item'],
                        'add_new'               => $post_type['add_new'],
                        'new_item'              => $post_type['new_item'],
                        'edit_item'             => $post_type['edit_item'],
                        'update_item'           => $post_type['update_item'],
                        'view_item'             => $post_type['view_item'],
                        'view_items'            => $post_type['view_items'],
                        'search_items'          => $post_type['search_items'],
                        'not_found'             => $post_type['not_found'],
                        'not_found_in_trash'    => $post_type['not_found_in_trash'],
                        'featured_image'        => $post_type['featured_image'],
                        'set_featured_image'    => $post_type['set_featured_image'],
                        'remove_featured_image' => $post_type['remove_featured_image'],
                        'use_featured_image'    => $post_type['use_featured_image'],
                        'insert_into_item'      => $post_type['insert_into_item'],
                        'uploaded_to_this_item' => $post_type['uploaded_to_this_item'],
                        'items_list'            => $post_type['items_list'],
                        'items_list_navigation' => $post_type['items_list_navigation'],
                        'filter_items_list'     => $post_type['filter_items_list']
                    ),
                    'label'                     => $post_type['label'],
                    'description'               => $post_type['description'],
                    'hierarchical'              => $post_type['hierarchical'],
                    'public'                    => $post_type['public'],
                    'show_ui'                   => $post_type['show_ui'],
                    'show_in_menu'              => $post_type['show_in_menu'],
                    'menu_position'             => $post_type['menu_position'],
                    'show_in_admin_bar'         => $post_type['show_in_admin_bar'],
                    'show_in_nav_menus'         => $post_type['show_in_nav_menus'],
                    'can_export'                => $post_type['can_export'],
                    'has_archive'               => $post_type['has_archive'],
                    'exclude_from_search'       => $post_type['exclude_from_search'],
                    'publicly_queryable'        => $post_type['publicly_queryable'],
                    'capability_type'           => $post_type['capability_type'],
                    'menu_icon'                 => $post_type['menu_icon']
                )
            );
        }
    }
}