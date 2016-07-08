<?php

function getAllPosts($type, $numberOfPosts = -1, $paged,  $ignoreCurrentPost = true) {
    $query = internal_create_query($type, $numberOfPosts, $paged, $ignoreCurrentPost);
    $posts = get_posts($query);
    $query = new WP_Query($query);
    $count = $query->found_posts;
    $response['posts'] = $posts;
    $response['count'] = $count;
    return $response;
}

function getFilterPosts($type, $numberOfPosts = -1, $paged, $tax, $loc, $meta = '') {
    $query = internal_create_query_filter($type, $numberOfPosts, $paged, $tax, $loc, $meta);
    $posts = get_posts($query);
    $query = new WP_Query($query);
    $max_num_pages = $query->max_num_pages;
    $count = $query->found_posts;
    $response['posts'] = $posts;
    $response['max'] = $max_num_pages;
    $response['count'] = $count;
    return $response;
}

function getFilterPostsNumbers($restaurants) {
    $ids = array();
    foreach($restaurants as $restaurant) {
        array_push($ids, $restaurant->ID);
    }
    $posts = getAllPostsByTaxonomy($ids);
    return $posts;

}

function getRelated($type, $loc, $cuisine, $numberOfPosts = -1, $ignoreCurrentPost = true) {
    $query = internal_create_query_related($type, $loc, $cuisine, $numberOfPosts, $ignoreCurrentPost);
    $posts = get_posts($query);
    if(empty($posts)) {
        $query = internal_create_query_random($type, $numberOfPosts, true);
        $posts = get_posts($query);
    }
    return $posts;
}



function removeAllFeatured($id) {
    $args = array(
        'post_type'  => array('featured'),
        'post__not_in' => array($id),
        'meta_query' => array(
            array(
                'key'     => 'featured',
                'value'   => 1,
            ),
        ),
    );
    $query = new WP_Query( $args );
    if($query->get_posts() != null) {
        $post = $query->get_posts();
        update_post_meta($post[0]->ID, 'featured', 0, 1);
    }
}

function getFeaturedPost() {
    $args = array(
        'post_type'  => array('featured'),
        'meta_query' => array(
            array(
                'key'     => 'featured',
                'value'   => 1,
            ),
        ),
    );
    $query = new WP_Query( $args );
    $post = $query->get_posts();
    return $post[0];
}


function getLatestNews($id = '') {
    $query = internal_create_query_latest_news(array('news', 'whitepaper', 'support'), 1, $id);
    $post = get_posts($query);
    return $post;
}

function getRelatedPosts($tags, $post) {
    $query = internal_related_posts($tags, $post);
    $posts = get_posts($query);
    return $posts;
}

function getArchiveNews($numberOfPosts = 7, $id = '') {
    $query = internal_create_query_latest_news('news', $numberOfPosts, $id);
    $posts = get_posts($query);
    array_shift($posts);
    return $posts;
}

function getMaxPagination($type, $numberOfPosts) {
    return internal_max_pagination($type, $numberOfPosts);
}

function getCategories() {
    $args = array(
        'type'                     => 'news',
        'child_of'                 => 0,
        'parent'                   => '',
        'orderby'                  => 'name',
        'order'                    => 'ASC',
        'hide_empty'               => 1,
        'hierarchical'             => 1,
        'exclude'                  => 1,
        'include'                  => '',
        'number'                   => '',
        'taxonomy'                 => 'category',
        'pad_counts'               => false

    );

    return get_categories( $args );
}

/**
 * Do not rely on this function, consider it private
 *
 * @param $postType
 * @param $numberOfPosts
 * @param $ignoreCurrentPost
 * @return array The prepared array for the query
 */
function internal_create_query($postType, $numberOfPosts, $paged, $ignoreCurrentPost) {
    $query = array(
        'paged' => $paged,
        'posts_per_page' => $numberOfPosts,
        'post_type' => $postType,
        'post_status' => 'publish',
        'orderby' => 'title',
        'order' => 'ASC',
        'suppress_filters' => false
    );
    if ($ignoreCurrentPost) {
        global $post;
        $query['post__not_in'] = array($post->ID);
    }
    return $query;
}

function internal_create_query_related($type, $loc, $cuisine, $numberOfPosts, $ignoreCurrentPost) {
    $taxQuery = array();
    if(!empty($loc)) {
        array_push($taxQuery, array_merge(array( 'relation' => 'OR' ), array_values($loc)));
    }
    if(!empty($cuisine)) {
        array_push($taxQuery, array_merge(array( 'relation' => 'OR' ), array_values($cuisine)));
    }

    $query = array(
        'posts_per_page' => $numberOfPosts,
        'post_type' => $type,
        'post_status' => 'publish',
        'meta_key'	        => 'food',
        'orderby'			=> 'meta_value_num',
        'order'				=> 'DESC',
        'suppress_filters' => false,
        'tax_query' => $taxQuery
    );
    if ($ignoreCurrentPost) {
        global $post;
        $query['post__not_in'] = array($post->ID);
    }
    return $query;
}

function internal_create_query_filter($postType, $numberOfPosts, $paged, $tax, $loc, $meta) {
    $taxQuery = array();
    if(!empty($tax)) {
        array_push($taxQuery, array_values($tax));
    }

    if(!empty($loc)) {
        array_push($taxQuery, array_merge(array( 'relation' => 'OR' ), array_values($loc)));
    }
    
    $query = array(
        'paged' => $paged,
        'posts_per_page' => $numberOfPosts,
        'post_type' => $postType,
        'post_status' => 'publish',
        'orderby' => 'title',
        'order' => 'ASC',
        'suppress_filters' => false,
        'meta_query' => array_merge(
            array( 'relation' => 'AND' ),
            array_values($meta)
        ),
        'tax_query' => $taxQuery
    );
    return $query;
}

function internal_create_query_random($postType, $numberOfPosts, $ignoreCurrentPost) {
    $query = array(
        'posts_per_page' => $numberOfPosts,
        'post_type' => $postType,
        'post_status' => 'publish',
        'orderby' => 'rand',
        'suppress_filters' => false
    );
    if ($ignoreCurrentPost) {
        global $post;
        $query['post__not_in'] = array($post->ID);
    }
    return $query;
}

function internal_create_query_latest_news($postType, $numberOfPosts, $id) {
    $query = array(
        'numberposts' => $numberOfPosts,
        'post_type' => $postType,
        'cat' => $id,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
        'suppress_filters' => false
    );
    return $query;
}

function internal_create_query_news_by_category($postType, $paged, $id, $numberOfPosts) {
    $query = array(
        'post_type' => $postType,
        'paged' => $paged,
        'posts_per_page' => $numberOfPosts,
        'cat' => $id,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
    );

    return $query;
}

function internal_create_search_query($vars) {
    $query = array(
        'post_type' => array( 'restaurant', 'list', 'article' ),
        's' => $vars,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',

    );
    return $query;
}

function internal_create_meta_query($vars) {
    $query = array(
        'post_type' => array( 'restaurant', 'list', 'article' ),
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => 'regions',
                'value' => $vars,
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'type',
                'value' => $vars,
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'tags',
                'value' => $vars,
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'location',
                'value' => $vars,
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'website',
                'value' => $vars,
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'working_dayshours',
                'value' => $vars,
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'order',
                'value' => $vars,
                'compare' => 'LIKE'
            )
        )
    );

    return $query;

}

function internal_max_pagination($postType, $numberOfPosts) {
    $query = array(
        'posts_per_page' => $numberOfPosts,
        'post_type' => $postType,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
        'suppress_filters' => false
    );
    $query = new WP_Query($query);
    $max_num_pages = $query->max_num_pages;
    return $max_num_pages;
}

function internal_related_posts($tags, $post) {
    $first_tag = $tags[0]->term_id;
    $query = array(
        'tag__in' => array($first_tag),
        'post__not_in' => array($post->ID),
        'posts_per_page'=>5,
        'caller_get_posts'=>1
    );
    return $query;
}

function getAllPostsByTaxonomy($ids) {
    global $wpdb;
    $query = 'SELECT count(*) as numbers, slug FROM wp_term_relationships JOIN wp_terms ON wp_term_relationships.term_taxonomy_id = wp_terms.term_id
              WHERE object_id IN (' . implode(',', $ids) . ') GROUP BY term_taxonomy_id';
    $myrows = $wpdb->get_results($query);
    
    return $myrows;
}