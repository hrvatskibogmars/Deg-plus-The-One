<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>

<article class="blank blank--search">
	<h2><? _e('Page not found - 404', 'truffle') ?></h2>
	<p>
		<? _e('The page you have requested does not exist. Sorry.', 'truffle') ?> <br>
		<? _e('Try returning to homepage to find what you’re looking for.', 'truffle') ?>
	</p>
	<a href="<?= home_url() ?>" class="is-link"><? _e('Take me to homepage', 'truffle') ?></a>
</article>

<?php get_footer(); ?>
