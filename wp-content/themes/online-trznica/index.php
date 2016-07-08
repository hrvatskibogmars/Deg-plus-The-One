<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage angelo
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <?php
        // Include the page content template.

        $args = array(
            'post_status' => 'publish',
            'posts_per_page' => -1);
        $my_query = null;
        $my_query = new WP_Query($args);
        if( $my_query->have_posts() ) {
            while ($my_query->have_posts()) : $my_query->the_post();
                var_dump(get_field('slider'));
            endwhile;
        }
        wp_reset_query();  // Restore global post data stomped by the_post().
        the_content();

        ?>

    </main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_footer(); ?>
