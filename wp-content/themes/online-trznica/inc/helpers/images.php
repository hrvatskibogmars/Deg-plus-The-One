<?php
/**
 * Created by PhpStorm.
 * User: st00ne1
 * Date: 07/07/15
 * Time: 16:17
 */

//Don't add image size with name 'full'. ACF uses this size for the original image
add_image_size( 'header', 1920, 800, true );
add_image_size( 'info', 1760, 642, true );
add_image_size( 'preview', 535, 352, true );
add_image_size( 'featured', 962, 640, true );

function get_image_from_custom_field($image, $size){
    if(!is_array($image)){
        throw new Exception("This image is not an array, check input");

    }

    if(!isset($image['sizes'])){
        throw new Exception("This image is missing 'sizes' attribute");

    }

    check_size_exist($size);

    if(isset($image['sizes'][$size])){
        return $image['sizes'][$size];
    }

    return default_image($size);

}

function get_images_from_custom_field_gallery($gallery, $size){
    if(!is_array($gallery)){
        return array(default_image($size));
        throw new Exception("This gallery is not an array, check input");

    }

    $output = array();
    foreach ($gallery as $image ) {
        $output[] = get_image_from_custom_field($image, $size);
    }

    return $output;
}

function get_featured_image($size, $id = false){
    check_size_exist($size);

    $postid = ($id)? $id : get_the_ID();
    $src = wp_get_attachment_image_src( get_post_thumbnail_id( $postid ), $size );
    if(!$src){
       return default_image($size);
    }

    return $src[0];

}

function default_image($size){
    return 'default';
}

function check_size_exist($size){

    $registeredSized = get_intermediate_image_sizes();
    if(!in_array($size, $registeredSized)){
        throw new Exception("This image size is not registered in wordpress");

    }
}