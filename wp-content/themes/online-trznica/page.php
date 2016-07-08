<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage angelo
 */
// If there is no post, include home page
if(!have_posts()) {
	$query = new WP_Query(array("pagename"=>"home"));
	if($query->have_posts()) {
		$query->the_post();
	}
} else {
	the_post();
}

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
			// Include the page content template.
            the_content();
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
