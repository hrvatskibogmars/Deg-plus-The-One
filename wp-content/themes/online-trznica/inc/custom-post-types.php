<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 21.6.2015.
 * Time: 11:46
 */



/**
 *  Template function for adding custom post type. AutoLoader class should auto include this file.
 *
 *  Following code will add a new custom post type.
 *  Please check codex for more information on custom post types
 *  Custom post types: https://codex.wordpress.org/Post_Types#Custom_Post_Types
 *  Register post types: https://codex.wordpress.org/Function_Reference/register_post_type#Arguments
 */
function themes_taxonomy() {
    register_taxonomy(
        'wine-regions',  //The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
        'wine',        //post type name
        array(
            'hierarchical' => true,
            'label' => 'Wine Regions',  //Display name
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'wine-regions', // This controls the base slug that will display before each term
                'with_front' => false // Don't display the category base before
            )
        )
    );

    register_taxonomy(
        'wine-type',  //The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
        'wine',        //post type name
        array(
            'hierarchical' => true,
            'label' => 'Wine Type',  //Display name
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'wine-type', // This controls the base slug that will display before each term
                'with_front' => false // Don't display the category base before
            )
        )
    );

    register_taxonomy(
        'regions',  //The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
        'restaurant',        //post type name
        array(
            'hierarchical' => true,
            'label' => 'Regions',  //Display name
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'regions', // This controls the base slug that will display before each term
                'with_front' => false // Don't display the category base before
            )
        )
    );

    register_taxonomy(
        'type',  //The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
        'restaurant',        //post type name
        array(
            'hierarchical' => true,
            'label' => 'Type',  //Display name
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'type', // This controls the base slug that will display before each term
                'with_front' => false // Don't display the category base before
            )
        )
    );

    register_taxonomy(
        'tags',  //The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
        'restaurant',        //post type name
        array(
            'hierarchical' => true,
            'label' => 'Tags',  //Display name
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'tag', // This controls the base slug that will display before each term
                'with_front' => false // Don't display the category base before
            )
        )
    );

}
add_action( 'init', 'themes_taxonomy');

function create_product_post_type() {
    register_post_type( 'product',
        array(
            'labels' => array(
                'name' => __( 'Proizvodi' ),
                'singular_name' => __( 'Proizvod' )
            ),
            'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt'),
            'public'             => true,
            'publicly_queryable' => true,
            'map_meta_cap' => true,
            'capability_type' => 'product',
            'has_archive' => true,
            'hierarchical' => false,
            'rewrite' => array('slug' => 'restaurant', 'with_front' => true),
        )
    );

}
add_action( 'init', 'create_product_post_type' );





/**
 * Using ACF to create option pages.
 *
 * Notice: these options work with WPML, but every language contains options for itself.
 * -> Meaning, if you have 3 languages, you will have to change options on all three languages separately
 *      -> There is no linking between language options
 */
if(function_exists('acf_add_options_page')){
    acf_add_options_page(array(
        'page_title' => 'Theme options',
        'menu_title' => 'Theme options',
        'menu_slug' => 'theme-options',
        'capability' => 'edit_posts',
        'parent_slug' => '',
        'position' => false,
        'icon_url' => false,
        'redirect' => false,
    ));

    /*
    acf_add_options_sub_page(array(
        'page_title' => 'Homepage',
        'menu_title' => 'Homepage',
        'menu_slug' => 'home-options',
        'capability' => 'edit_posts',
        'parent_slug' => 'theme-options',
        'position' => false,
        'icon_url' => false,
        'redirect' => false,
    ));

    acf_add_options_sub_page(array(
        'page_title' => 'Footer',
        'menu_title' => 'Footer',
        'menu_slug' => 'footer-options',
        'capability' => 'edit_posts',
        'parent_slug' => 'theme-options',
        'position' => false,
        'icon_url' => false,
        'redirect' => false,
    ));
    */
}
