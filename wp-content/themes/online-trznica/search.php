<?php
/**
 * The template for displaying search results pages.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
global $wp_query;
get_header();
$posts = $wp_query->get_posts();
if($posts) {
	$response = getOrderedSearchResults($posts);
}
?>
<!-- MAIN WRAPPER -->
<div class="wrapper main-wrapper main-wrapper--right is-list">

	<div class="container">

		<header class="main-header main-header--list">

			<h2><? _e('Showing results for') ?> “<?php echo get_search_query(); ?>”</h2>

		</header>

		<aside class="sidebar sidebar--list">
			<? if($posts) {
				get_partial('_render-page-menu', $response);
			} ?>

		</aside>

		<main class="main">
			<? if($posts) { ?>
				<div class="search__list">

					<?
					if(!empty($response['restaurants'])) { ?>
					<div class="search__block search__restaurants">

						<header>
							<h2 class="has-line">
								<span><? _e('Restaurants') ?></span>
							</h2>
						</header>
					<?
						get_partial('_item', array(
							'restaurants' => $response['restaurants']
						));
					?>
						<a href="#" class="button button--white-with-red">Show more</a>
					</div>
					<?
					}
					?>

					<?
					if(!empty($response['articles'])) { ?>
						<div class="search__block search__articles">

							<header>
								<h2 class="has-line">
									<span><? _e('Articles') ?></span>
								</h2>
							</header>
							<?
							get_partial('article/_article-item', array(
									'articles' => $response['articles']
								)
							);
							?>
							<a href="#" class="button button--white-with-red">Show more</a>
						</div>
						<?
					}
					?>


					<?
					if(!empty($response['lists'])) { ?>
						<div class="search__block search__lists">

							<header>
								<h2 class="has-line">
									<span><? _e('Lists') ?></span>
								</h2>
							</header>
							<?
							get_partial('_item', array(
								'restaurants' => $response['lists']
							));
							?>
							<a href="#" class="button button--white-with-red">Show more</a>
						</div>
						<?
					}
					?>

					<?
					if(!empty($response['wines'])) { ?>
						<div class="search__block search__wines">

							<header>
								<h2 class="has-line">
									<span><? _e('Wines') ?></span>
								</h2>
							</header>
							<?
							get_partial('_item', array(
								'restaurants' => $response['wines']
							));
							?>
							<a href="#" class="button button--white-with-red">Show more</a>
						</div>
						<?
					}
					?>


				</div>
			<?
			} else {
				get_partial('_search-blank', array(
					'vars' => get_search_query()
				));
			} ?>

		</main>

	</div>

</div>
<!-- /MAIN WRAPPER -->
<?php get_footer(); ?>
