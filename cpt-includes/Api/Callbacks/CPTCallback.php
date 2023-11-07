<?php

namespace EliaPc\CptManager\Api\Callbacks;

use EliaPc\CptManager\Base\BaseController;

class CPTCallback extends BaseController{

    public function cptManagerPage():void{
        /*echo $this->plugin_dir.'<br />';
        echo $this->plugin_url.'<br />';
        echo 'cpt-manager/cpt-manager.php'.'<br />';
        //var_dump( $this->is_plugin_active );
        echo 'Manage CPT';*/
        do_action('get_post_type_settings_admin_form');
    }

    public function cptManagerPage2():void{
        echo 'صفحه دوم مدیریت';
    }

    public function cptManagerPage21():void{
        echo 'صفحه دوم اول مدیریت';
    }

    public function cptManagerPageU1():void{
        echo 'cpt manager page under 1';
    }

    public function inputField(array $args):void{
        $name = $args['name'];
        $option_name = $args['option_name'];
        $input = get_option( $option_name );
        $input = ( !empty( $input ) ) ? $input  : array();
        //var_dump($input);die();
        $value = '';
        if( isset( $_GET['edit_post'] ) ){
            $value = $input[$_GET['edit_post']][$name];
        }
        echo '<input type="text" class="regular-text" name="'.$option_name.'['.$name.']" id="'.$name.'" value="'.$value.'" placeholder="'.$args['placeholder'].'">';
    }

    public function checkboxField( array $args ): void {
        $name = $args['name'];
        $option_name = $args['option_name'];
        $input = get_option( $option_name );
        $input = ( !empty( $input ) ) ? $input : array();
        $is_checked = false;
        if( isset( $_GET['edit_post'] ) ){
            $is_checked = isset( $input[$_GET['edit_post']][$name] ) && intval( $input[$_GET['edit_post']][$name] ) === 1;
        }
        echo '<label class="switch"><input name="'.$option_name.'['.$name.']" id="'.$name.'" type="checkbox" '.( $is_checked ? 'checked' : '' ).'><span class="slider"></span></label>';
    }

    public function cptSanitize($input){
        $output = get_option( 'cpt_manager_plugin_settings' );
        $output = ( ! empty( $output ) && is_array( $output ) ) ? $output : array();
        //var_dump($output);die();
        if( !empty( $input['post_type'] ) && trim( $input['post_type'] )!=='' ) {
            $output[ $input['post_type'] ] = [
                'post_type'           => sanitize_text_field( $input['post_type'] ),
                'name'                => sanitize_text_field( $input['name'] ),
                'singular_name'       => sanitize_text_field( $input['singular_name'] ),
                'menu_name'           => sanitize_text_field( $input['menu_name'] ),
                'menu_icon'           => sanitize_text_field( $input['menu_icon'] ),
                'menu_position'       => ( is_numeric( $input['menu_position'] ) ) ? intval( $input['menu_position'] ) : 5 ,
                'public'              => isset( $input['public'] ),
                'has_archive'         => isset( $input['has_archive'] ),
                'show_in_admin_bar'   => isset( $input['show_in_admin_bar'] ),
                'show_in_nav_menus'   => isset( $input['show_in_nav_menus'] ),
                'show_in_rest'        => isset( $input['show_in_rest'] ),
                'hierarchical'        => isset( $input['hierarchical'] ),
                'show_ui'             => isset( $input['show_ui'] ),
                'show_in_menu'        => isset( $input['show_in_menu'] ),
                'can_export'          => isset( $input['can_export'] ),
                'exclude_from_search' => isset( $input['exclude_from_search'] ),
                'publicly_queryable'  => isset( $input['publicly_queryable'] )
            ];
        }
        return $output;
    }

    public function cptManagerAdminSection(){

    }
}












