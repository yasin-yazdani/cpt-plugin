<?php

namespace EliaPc\CptManager\Api\Templates\Admin;


class post_type_settings extends generals {
    public function show():void{
        settings_errors();
        echo $this->getHeader();
        $tab = ( isset( $_GET['tab'] ) && trim( $_GET['tab'])!=='' ) ? trim( $_GET['tab']) : 'home';
        ?>

        <nav>
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link <?= ( ( $tab==='home' ) ? 'active' : '' );  ?>" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">
                <?php echo ( ( isset( $_GET['edit_post'] ) && trim( $_GET['edit_post'] )!=='' ) ? esc_html__('Edit Post Type', 'cpt_plugin') : esc_html__('Add Post Type', 'cpt_plugin') ); ?>
            </button>
            <button class="nav-link <?= ( ( $tab==='profile' ) ? 'active' : '' );  ?>" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                <?php echo esc_html__('Created Post Types' , 'cpt_plugin'); ?>
            </button>
            <button class="nav-link <?= ( ( $tab==='code' ) ? 'active' : '' );  ?>" id="nav-code-tab" data-bs-toggle="tab" data-bs-target="#nav-code" type="button" role="tab" aria-controls="nav-code" aria-selected="false">
                <?php echo esc_html__('Export Post Type Codes' , 'cpt_plugin'); ?>
            </button>
          </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade <?= ( ( $tab==='home' ) ? 'show active' : '' );  ?>" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"><?php $this->addPostType() ?></div>
          <div class="tab-pane fade <?= ( ( $tab==='profile' ) ? 'show active' : '' );  ?>" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab"><?php $this->editPostType() ?></div>
          <div class="tab-pane fade <?= ( ( $tab==='code' ) ? 'show active' : '' );  ?>" id="nav-code" role="tabpanel" aria-labelledby="nav-code-tab"><?php $this->exportPostTypeCodes() ?></div>
        </div>

<?php
        echo $this->getFooter();
    }

    private function addPostType(){
        echo '<form action="options.php" method="post">';
        settings_fields('cpt_manager_settings');
        do_settings_sections('cpt_manager');
        submit_button(esc_html__('Add post type' , 'cpt_plugin'));
        echo '</form>';
    }

    private function editPostType(){
        $options = get_option('cpt_manager_plugin_settings');
?>
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Post Type ID</th>
                <th scope="col">Post Type Name</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
                <th scope="col">Export Codes</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 1;
            foreach ($options as $option) :
            ?>
            <tr>
                <th scope="row"><?= $i ?></th>
                <td><?= $option['post_type'] ?></td>
                <td><?= $option['name'] ?></td>
                <td><a type="button" class="btn btn-primary" href="admin.php?page=cpt_manager&edit_post=<?= $option['post_type'] ?>">Edit</a></td>
                <td>
                    <form action="options.php" method="post">
                        <?php
                        settings_fields('cpt_manager_settings');
                        echo '<input type="hidden" name="post_type" value="'.$option['post_type'].'">';
                        echo '<input type="hidden" name="nonce" value="'.wp_create_nonce('delete_post_type_secure').'">';
                        //submit_button(esc_html__('Delete', 'cpt_plugin'), 'btn btn-danger', 'delete_post_type');
                        echo '<button type="submit" class="btn btn-danger" name="delete_post_type">Delete</button>';
                        ?>
                    </form>
                </td>
                <td>
                    <form method="post" action="admin.php?page=cpt_manager&tab=code">
                        <?php
                        echo '<input type="hidden" name="post_type" value="'.$option['post_type'].'">';
                        echo '<button type="submit" class="btn btn-warning">Get Codes</button>';
                        ?>
                    </form>
                </td>
            </tr>
            <?php
            $i++;
            endforeach;
            ?>
            </tbody>
        </table>
<?php
    }

    private function exportPostTypeCodes(){
        if (isset($_POST['post_type']) && trim($_POST['post_type']) !== ''){
            $ExpDetail = get_option( 'cpt_manager_plugin_settings' )[$_POST['post_type']];
            $menu_pos=isset($ExpDetail['menu_position']) ? ((trim($ExpDetail['menu_position']) !== '') ? ((filter_var($ExpDetail['menu_position'],FILTER_VALIDATE_INT) !== false) ? $ExpDetail['menu_position'] : 5) :5) : 5;
            //var_dump($ExpDetail);
            $post_type = array(
                'post_type'             => $ExpDetail['post_type'],
                'name'                  => $ExpDetail['name'],
                'singular_name'         => $ExpDetail['singular_name'],
                'menu_name'             => $ExpDetail['menu_name'],
                'name_admin_bar'        => $ExpDetail['singular_name'],
                'archives'              => $ExpDetail['singular_name'] . ' Archives',
                'attributes'            => $ExpDetail['singular_name'] . ' Attributes',
                'parent_item_colon'     => 'Parent ' . $ExpDetail['singular_name'],
                'all_items'             => 'All ' . $ExpDetail['name'],
                'add_new_item'          => 'Add New ' . $ExpDetail['singular_name'],
                'add_new'               => 'Add New',
                'new_item'              => 'New ' . $ExpDetail['singular_name'],
                'edit_item'             => 'Edit ' . $ExpDetail['singular_name'],
                'update_item'           => 'Update ' . $ExpDetail['singular_name'],
                'view_item'             => 'View ' . $ExpDetail['singular_name'],
                'view_items'            => 'View ' . $ExpDetail['name'],
                'search_items'          => 'Search ' . $ExpDetail['name'],
                'not_found'             => 'No ' . $ExpDetail['singular_name'] . ' Found',
                'not_found_in_trash'    => 'No ' . $ExpDetail['singular_name'] . ' Found in Trash',
                'featured_image'        => 'Featured Image',
                'set_featured_image'    => 'Set Featured Image',
                'remove_featured_image' => 'Remove Featured Image',
                'use_featured_image'    => 'Use Featured Image',
                'insert_into_item'      => 'Insert into' . $ExpDetail['singular_name'],
                'uploaded_to_this_item' => 'Upload to this ' . $ExpDetail['singular_name'],
                'items_list'            => $ExpDetail['name'] . ' List',
                'items_list_navigation' => $ExpDetail['name'] . ' List Navigation',
                'filter_items_list'     => 'Filter' . $ExpDetail['name'] . ' List',
                'label'                 => $ExpDetail['singular_name'],
                'description'           => $ExpDetail['name'] . 'Custom Post Type',
                'hierarchical'          => $ExpDetail['hierarchical'] ? 'true' : 'false',
                'public'                => $ExpDetail['public'] ? 'true' :'false',
                'show_ui'               => $ExpDetail['show_ui'] ? 'true' :'false',
                'show_in_menu'          => $ExpDetail['show_in_menu'] ? 'true' :'false',
                'menu_position'         => intval($menu_pos),
                'show_in_admin_bar'     => $ExpDetail['show_in_admin_bar'] ? 'true' :'false',
                'show_in_nav_menus'     => $ExpDetail['show_in_nav_menus'] ? 'true' :'false',
                'can_export'            => $ExpDetail['can_export'] ? 'true' :'false',
                'has_archive'           => $ExpDetail['has_archive'] ? 'true' :'false',
                'exclude_from_search'   => $ExpDetail['exclude_from_search'] ? 'true' :'false',
                'publicly_queryable'    => $ExpDetail['publicly_queryable'] ? 'true' :'false',
                'capability_type'       => 'post',
                'menu_icon'             => (isset($ExpDetail['menu_icon']) ? ((trim($ExpDetail['menu_icon']) === '') ? 'false' : $ExpDetail['menu_icon']) : 'false'),
            );
            ?>



            <div class="m-3 text-lg-end">
                <button type="button" id="copyButton" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Copy Codes to Clipboard">
                    Copy to Clipboard
                </button>
            </div>

    <pre class="prettyprint" dir="ltr" id="copyText">
    // Register Custom Post Type
    function custom_post_type_register() {

        register_post_type(<?php echo $post_type['post_type']; ?>,
            [
                'labels' => [
                    'name'                  => esc_html__('<?php echo $post_type['name']; ?>','cpt_plugin'),
                    'singular_name'         => esc_html__('<?php echo $post_type['singular_name']; ?>','cpt_plugin'),
                    'menu_name'             => esc_html__('<?php echo $post_type['menu_name']; ?>', 'cpt_plugin'),
                    'name_admin_bar'        => esc_html__('<?php echo $post_type['name_admin_bar']; ?>','cpt_plugin'),
                    'archives'              => esc_html__('<?php echo $post_type['archives']; ?>','cpt_plugin'),
                    'attributes'            => esc_html__('<?php echo $post_type['attributes']; ?>','cpt_plugin'),
                    'parent_item_colon'     => esc_html__('<?php echo $post_type['parent_item_colon']; ?>','cpt_plugin'),
                    'all_items'             => esc_html__('<?php echo $post_type['all_items']; ?>','cpt_plugin'),
                    'add_new_item'          => esc_html__('<?php echo $post_type['add_new_item']; ?>','cpt_plugin'),
                    'add_new'               => esc_html__('<?php echo $post_type['add_new']; ?>','cpt_plugin'),
                    'new_item'              => esc_html__('<?php echo $post_type['new_item']; ?>','cpt_plugin'),
                    'edit_item'             => esc_html__('<?php echo $post_type['edit_item']; ?>','cpt_plugin'),
                    'update_item'           => esc_html__('<?php echo $post_type['update_item']; ?>','cpt_plugin'),
                    'view_item'             => esc_html__('<?php echo $post_type['view_item']; ?>','cpt_plugin'),
                    'view_items'            => esc_html__('<?php echo $post_type['view_items']; ?>','cpt_plugin'),
                    'search_items'          => esc_html__('<?php echo $post_type['search_items']; ?>','cpt_plugin'),
                    'not_found'             => esc_html__('<?php echo $post_type['not_found']; ?>','cpt_plugin'),
                    'not_found_in_trash'    => esc_html__('<?php echo $post_type['not_found_in_trash']; ?>','cpt_plugin'),
                    'featured_image'        => esc_html__('<?php echo $post_type['featured_image']; ?>','cpt_plugin'),
                    'set_featured_image'    => esc_html__('<?php echo $post_type['set_featured_image']; ?>','cpt_plugin'),
                    'remove_featured_image' => esc_html__('<?php echo $post_type['remove_featured_image']; ?>','cpt_plugin'),
                    'use_featured_image'    => esc_html__('<?php echo $post_type['use_featured_image']; ?>','cpt_plugin'),
                    'insert_into_item'      => esc_html__('<?php echo $post_type['insert_into_item']; ?>','cpt_plugin'),
                    'uploaded_to_this_item' => esc_html__('<?php echo $post_type['uploaded_to_this_item']; ?>','cpt_plugin'),
                    'items_list'            => esc_html__('<?php echo $post_type['items_list']; ?>','cpt_plugin'),
                    'items_list_navigation' => esc_html__('<?php echo $post_type['items_list_navigation']; ?>','cpt_plugin'),
                    'filter_items_list'     => esc_html__('<?php echo $post_type['filter_items_list']; ?>','cpt_plugin')
                ],
                'label'                     => esc_html__('<?php echo $post_type['label']; ?>','cpt_plugin'),
                'description'               => esc_html__('<?php echo $post_type['description']; ?>','cpt_plugin'),
                'hierarchical'              => <?php echo $post_type['hierarchical']; ?>,
                'public'                    => <?php echo $post_type['public']; ?>,
                'show_ui'                   => <?php echo $post_type['show_ui']; ?>,
                'show_in_menu'              => <?php echo $post_type['show_in_menu']; ?>,
                'menu_position'             => <?php echo $post_type['menu_position']; ?>,
                'show_in_admin_bar'         => <?php echo $post_type['show_in_admin_bar']; ?>,
                'show_in_nav_menus'         => <?php echo $post_type['show_in_nav_menus']; ?>,
                'can_export'                => <?php echo $post_type['can_export']; ?>,
                'has_archive'               => <?php echo $post_type['has_archive']; ?>,
                'exclude_from_search'       => <?php echo $post_type['exclude_from_search']; ?>,
                'publicly_queryable'        => <?php echo $post_type['publicly_queryable']; ?>,
                'capability_type'           => '<?php echo $post_type['capability_type']; ?>',
                'menu_icon'                 => <?php echo $post_type['menu_icon']; ?>
            ]
        ) ;
    }
    add_action( 'init', 'custom_post_type_register', 0 );
    </pre>

<?php
        }
        else{
            echo esc_html__('You need to choose a post type from second tab.' , 'cpt_plugin');
        }
    }
}
