<?php /** Template name: blog */ ?>
<?php

$query = new WP_Query([
    'post_type' => "post",
    "post_status" => "publish",
    "posts_per_page" => -1
]);

$posts = $query->get_posts();

?>

<main class="main">
    <div class="horiz">
        <ul class="horiz__list">
            <?php
            foreach ($posts as $post){
                /**
                 * @var $post WP_Post
                 */
                $fields = get_fields($post->ID);
                ?>
                <div class="products__item">
                    <div class="products__image">
                        <img src="<?=$data['image']['sizes']['large']?>" class="products__source" alt="">
                    </div>
                    <div class="products__info">
                        <h3 class="products__title"><?= $post->post_title ?></h3>
                        <p class="products__desc"><?= $post->post_content ?></p>
                    </div>
                </div>
            <?php
            }
            ?>
        </ul>
        <div class="load-more">
            <a href="#" class="load-more__anchor btn btn-black">Učitaj više</a>
        </div>
    </div>
    <?php get_partial('layout/_footer'); ?>
</main>
