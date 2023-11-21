<?php

namespace EliaPc\CptManager\Api\Templates\Admin;

class taxonomy_settings extends generals {
    public function show():void{
        settings_errors();
        echo $this->getHeader();
        $tab = ( isset( $_GET['tab'] ) && trim( $_GET['tab'])!=='' ) ? trim( $_GET['tab']) : 'home';
        ?>

        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link <?= ( ( $tab==='home' ) ? 'active' : '' );  ?>" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">
                    <?php echo ( ( isset( $_GET['edit_post'] ) && trim( $_GET['edit_post'] )!=='' ) ? esc_html__('Edit Taxonomy', 'cpt_plugin') : esc_html__('Add Taxonomy', 'cpt_plugin') ); ?>
                </button>
                <button class="nav-link <?= ( ( $tab==='profile' ) ? 'active' : '' );  ?>" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                    <?php echo esc_html__('Created Taxonomies' , 'cpt_plugin'); ?>
                </button>
                <button class="nav-link <?= ( ( $tab==='code' ) ? 'active' : '' );  ?>" id="nav-code-tab" data-bs-toggle="tab" data-bs-target="#nav-code" type="button" role="tab" aria-controls="nav-code" aria-selected="false">
                    <?php echo esc_html__('Export Taxonomy Codes' , 'cpt_plugin'); ?>
                </button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade <?= ( ( $tab==='home' ) ? 'show active' : '' );  ?>" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"><?php $this->addTaxonomy() ?></div>
            <div class="tab-pane fade <?= ( ( $tab==='profile' ) ? 'show active' : '' );  ?>" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab"><?php $this->editTaxonomy() ?></div>
            <div class="tab-pane fade <?= ( ( $tab==='code' ) ? 'show active' : '' );  ?>" id="nav-code" role="tabpanel" aria-labelledby="nav-code-tab"><?php $this->exportTaxonomyCodes() ?></div>
        </div>

        <?php
        echo $this->getFooter();
    }

    private function addTaxonomy(){
        echo '<form action="options.php" method="post">';
        settings_fields('tax_manager_settings');
        do_settings_sections('tax_manager');
        submit_button(esc_html__('Add taxonomy' , 'cpt_plugin'));
        echo '</form>';
    }

    private function editTaxonomy(){
        $options = get_option('tax_manager_plugin_settings');
        ?>
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Taxonomy ID</th>
                <th scope="col">Taxonomy Name</th>
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
                    <td><?= $option['taxonomy'] ?></td>
                    <td><?= $option['name'] ?></td>
                    <td><a type="button" class="btn btn-primary" href="admin.php?page=tax_manager&edit_post=<?= $option['taxonomy'] ?>">Edit</a></td>
                    <td>
                        <form action="options.php" method="post">
                            <?php
                            settings_fields('tax_manager_settings');
                            echo '<input type="hidden" name="taxonomy" value="'.$option['taxonomy'].'">';
                            echo '<input type="hidden" name="nonce" value="'.wp_create_nonce('delete_taxonomy_secure').'">';
                            //submit_button(esc_html__('Delete', 'cpt_plugin'), 'btn btn-danger', 'delete_post_type');
                            echo '<button type="submit" class="btn btn-danger" name="delete_taxonomy">Delete</button>';
                            ?>
                        </form>
                    </td>
                    <td>
                        <form method="post" action="admin.php?page=tax_manager&tab=code">
                            <?php
                            echo '<input type="hidden" name="taxonomy" value="'.$option['taxonomy'].'">';
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

    private function exportTaxonomyCodes(){
        if (isset($_POST['taxonomy']) && trim($_POST['taxonomy']) !== ''){
            $ExpDetail = get_option( 'tax_manager_plugin_settings' )[$_POST['taxonomy']];
            $menu_pos=isset($ExpDetail['menu_position']) ? ((trim($ExpDetail['menu_position']) !== '') ? ((filter_var($ExpDetail['menu_position'],FILTER_VALIDATE_INT) !== false) ? $ExpDetail['menu_position'] : 5) :5) : 5;
            //var_dump($ExpDetail);
            $taxonomy = array(
                'taxonomy'             => $ExpDetail['taxonomy'],
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
    function custom_taxonomy_register() {

        register_taxonomy(<?php echo $taxonomy['taxonomy']; ?>,
            [
                'labels' => [
                    'name'                  => esc_html__('<?php echo $taxonomy['name']; ?>','cpt_plugin'),
                    'singular_name'         => esc_html__('<?php echo $taxonomy['singular_name']; ?>','cpt_plugin'),
                    'menu_name'             => esc_html__('<?php echo $taxonomy['menu_name']; ?>', 'cpt_plugin'),
                    'name_admin_bar'        => esc_html__('<?php echo $taxonomy['name_admin_bar']; ?>','cpt_plugin'),
                    'archives'              => esc_html__('<?php echo $taxonomy['archives']; ?>','cpt_plugin'),
                    'attributes'            => esc_html__('<?php echo $taxonomy['attributes']; ?>','cpt_plugin'),
                    'parent_item_colon'     => esc_html__('<?php echo $taxonomy['parent_item_colon']; ?>','cpt_plugin'),
                    'all_items'             => esc_html__('<?php echo $taxonomy['all_items']; ?>','cpt_plugin'),
                    'add_new_item'          => esc_html__('<?php echo $taxonomy['add_new_item']; ?>','cpt_plugin'),
                    'add_new'               => esc_html__('<?php echo $taxonomy['add_new']; ?>','cpt_plugin'),
                    'new_item'              => esc_html__('<?php echo $taxonomy['new_item']; ?>','cpt_plugin'),
                    'edit_item'             => esc_html__('<?php echo $taxonomy['edit_item']; ?>','cpt_plugin'),
                    'update_item'           => esc_html__('<?php echo $taxonomy['update_item']; ?>','cpt_plugin'),
                    'view_item'             => esc_html__('<?php echo $taxonomy['view_item']; ?>','cpt_plugin'),
                    'view_items'            => esc_html__('<?php echo $taxonomy['view_items']; ?>','cpt_plugin'),
                    'search_items'          => esc_html__('<?php echo $taxonomy['search_items']; ?>','cpt_plugin'),
                    'not_found'             => esc_html__('<?php echo $taxonomy['not_found']; ?>','cpt_plugin'),
                    'not_found_in_trash'    => esc_html__('<?php echo $taxonomy['not_found_in_trash']; ?>','cpt_plugin'),
                    'featured_image'        => esc_html__('<?php echo $taxonomy['featured_image']; ?>','cpt_plugin'),
                    'set_featured_image'    => esc_html__('<?php echo $taxonomy['set_featured_image']; ?>','cpt_plugin'),
                    'remove_featured_image' => esc_html__('<?php echo $taxonomy['remove_featured_image']; ?>','cpt_plugin'),
                    'use_featured_image'    => esc_html__('<?php echo $taxonomy['use_featured_image']; ?>','cpt_plugin'),
                    'insert_into_item'      => esc_html__('<?php echo $taxonomy['insert_into_item']; ?>','cpt_plugin'),
                    'uploaded_to_this_item' => esc_html__('<?php echo $taxonomy['uploaded_to_this_item']; ?>','cpt_plugin'),
                    'items_list'            => esc_html__('<?php echo $taxonomy['items_list']; ?>','cpt_plugin'),
                    'items_list_navigation' => esc_html__('<?php echo $taxonomy['items_list_navigation']; ?>','cpt_plugin'),
                    'filter_items_list'     => esc_html__('<?php echo $taxonomy['filter_items_list']; ?>','cpt_plugin')
                ],
                'label'                     => esc_html__('<?php echo $taxonomy['label']; ?>','cpt_plugin'),
                'description'               => esc_html__('<?php echo $taxonomy['description']; ?>','cpt_plugin'),
                'hierarchical'              => <?php echo $taxonomy['hierarchical']; ?>,
                'public'                    => <?php echo $taxonomy['public']; ?>,
                'show_ui'                   => <?php echo $taxonomy['show_ui']; ?>,
                'show_in_menu'              => <?php echo $taxonomy['show_in_menu']; ?>,
                'menu_position'             => <?php echo $taxonomy['menu_position']; ?>,
                'show_in_admin_bar'         => <?php echo $taxonomy['show_in_admin_bar']; ?>,
                'show_in_nav_menus'         => <?php echo $taxonomy['show_in_nav_menus']; ?>,
                'can_export'                => <?php echo $taxonomy['can_export']; ?>,
                'has_archive'               => <?php echo $taxonomy['has_archive']; ?>,
                'exclude_from_search'       => <?php echo $taxonomy['exclude_from_search']; ?>,
                'publicly_queryable'        => <?php echo $taxonomy['publicly_queryable']; ?>,
                'capability_type'           => '<?php echo $taxonomy['capability_type']; ?>',
                'menu_icon'                 => <?php echo $taxonomy['menu_icon']; ?>
            ]
        ) ;
    }
    add_action( 'init', 'custom_taxonomy_register', 0 );
    </pre>

            <?php
        }
        else{
            echo esc_html__('You need to choose a taxonomy from second tab.' , 'cpt_plugin');
        }
    }
}