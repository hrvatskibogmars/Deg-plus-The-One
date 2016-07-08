<?php
/**
 * Created by PhpStorm.
 * User: ninomihovilic
 * Date: 20/05/16
 * Time: 12:44
 */

function load_custom_wp_admin_js() {
    wp_register_script( 'admin-js', get_template_directory_uri() .'/static/admin/admin.js');
    wp_enqueue_script( 'admin-js' );
}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_js' );