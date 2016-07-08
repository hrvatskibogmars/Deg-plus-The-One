<?php /** Template name: Home page */ ?>
<?php

the_post();

get_header();

$query = new WP_Query(array(
    "post_type" => "product",
    "posts_per_page" => 6
));

$posts = $query->get_posts();

?>
    <main class="main p-home">
        <nav class="navigation">
            <?php get_partial('layout/user-navigation')?>
        </nav>
        <div class="cover">
            <div class="cover__image">
                <div class="cover__text">
                    <h1>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</h1>
                </div>
            </div>
        </div>
        <div class="products">
            <?php
                foreach($posts as $p) {
                    get_partial('products/item', array("data" => getProductData($p)));
                }
            ?>
        </div>
    </main>

<?php

get_footer();
