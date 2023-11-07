<?php

namespace EliaPc\CptManager\Api\Templates\Admin;


class post_type_settings extends generals {
    public function show():void{
        settings_errors();
        echo $this->getHeader();
?>

        <nav>
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true"><?php echo esc_html__('Add/Edit Post Type' , 'cpt_plugin'); ?></button>
            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false"><?php echo esc_html__('Created Post Types' , 'cpt_plugin'); ?></button>
          </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"><?php $this->addPostType() ?></div>
          <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab"><?php $this->editPostType() ?></div>
        </div>

<?php
        echo $this->getFooter();
    }

    public function addPostType(){
        echo '<form action="options.php" method="post">';
        settings_fields('cpt_manager_settings');
        do_settings_sections('cpt_manager');
        submit_button(esc_html__('Add post type' , 'cpt_plugin'));
        echo '</form>';
    }

    public function editPostType(){
        $options = get_option('cpt_manager_plugin_settings');
?>
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Post Type ID</th>
                <th scope="col">Post Type Name</th>
                <th scope="col">Edit</th>
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
            </tr>
            <?php
            $i++;
            endforeach;
            ?>
            </tbody>
        </table>
<?php
    }
}
