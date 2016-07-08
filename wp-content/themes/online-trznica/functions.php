<?php

define("INCLUDE_PATH", get_template_directory() . "/inc/");
define("TEMPLATE_PATH", get_template_directory() . "/");
define("INCLUDE_URL", get_template_directory_uri());
define('FS_METHOD','direct');

require get_template_directory() . "/inc/vendors/AutoLoader.php";
add_image_size( 'home-thumb', 408, 305, true);
add_image_size( 'default-thumb', 150, 150);
add_image_size( 'detail-thumb', 350, 250);



//Initialize the update checker.
$example_update_checker = new ThemeUpdateChecker(
    'ultimate-croatia',                                            //Theme folder name, AKA "slug".
    'http://deghq.com/dwp/service/?identifier=c2501b18f69899383b945bc6c494de44&type=manifest' //URL of the metadata file.
);

add_action('wp_head','pluginname_ajaxurl');
function pluginname_ajaxurl() {
    ?>
    <script type="text/javascript">
        var ajaxurl = '<?php echo admin_url('admin-ajax.php') . '?lang=' . ICL_LANGUAGE_CODE ?>';
    </script>
    <?php
}
/**
 * Pretty dump
 * @param $obj
 */
function dump($obj) {
    echo "<pre class='debug'>";
    var_dump($obj);
    echo "</pre>";
}

/**
 * Base url convertion method.
 * @param $url
 * @return string
 */
function bu($url) {
    $clean = trim($url);
    return INCLUDE_URL . "/static/" .$clean;
}

function au($url) {
    $clean = trim($url);
    return get_template_directory() . "/static/" .$clean;
}


/**
 * MENU
 */
function register_my_menu() {
    register_nav_menu('header-menu',__( 'Header Menu' ));
}
add_action( 'init', 'register_my_menu' );
function register_my_menus() {
    register_nav_menus(
        array(
            'header-menu' => __( 'Header Menu' ),
        )
    );
}
add_action( 'init', 'register_my_menus' );


add_action( 'user_register', function( $user_id) {
    if($user_id) {
        update_user_meta($user_id, 'phone', $_POST['phone']);

        wp_update_user( array('ID' => $user_id, 'role' => 'Korisnik'));

        wp_signon(array(
            'user_login' => $_POST['reg_username'],
            'user_password' => $_POST['reg_password'],
            'remember' => true,
            ));

        wp_redirect( get_site_url() );
    }
}, 10, 1 );



add_action('admin_init','korisnik_add_role',999);
function korisnik_add_role()
{

    // Add the roles you'd like to administer the custom post types
    $roles = array('Korisnik');

    // Loop through each role and assign capabilities
    foreach ($roles as $the_role) {

        $role = get_role($the_role);

        $role->add_cap('read_product');
        $role->add_cap('edit_product');
        $role->add_cap('publish_product');
        $role->add_cap('delete_published_product');

    }
}


function getProductData(WP_Post $post) {
    $fields = get_fields($post->ID);
    if(!isset($fields['description'])){
        $fields['description'] = $fields['short_description'];
    }

    $isOpg = get_user_meta($post->post_author, 'opg', true);
    $opgName = $isOpg ? get_user_meta($post->post_author, 'name', true) : "";
    return array_merge(
        $fields,
        array(
            "title" => $post->post_title,
            "id" => $post->ID,
            "price" => formatProductPrice($fields),
            'isOpg' => $isOpg,
            'opgName' => $opgName,
        )
    );
}



function getOPGData(WP_User $user) {

    $userId = "user_" . $user->ID;
    $certificate = get_field('certificates', $userId);
    return [
        'title' => get_field('name', $userId),
        'description' => get_field('description', $userId),
        'address' => get_field('address', $userId),
        'email' => $user->user_email,
        'profile_image' => get_field('profile_image', $userId),
        'certificate' => $certificate['sizes']['large']
    ];
}


function formatProductPrice($data) {
    switch($data['unit']) {
        case 'komad':
            $t = "/kom";
            break;
        default:
            $t = "/kg";
    }

    return number_format_i18n( $data['price'], 2) . " kn" . $t;
}

add_action('acf/save_post', function( $post_id) {

});