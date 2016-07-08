<?php /** Template name: Home page */ ?>
<?php

the_post();

get_header();

$query = new WP_Query(array(
    "post_type" => "product",
    "orderby" => "meta_value_num",
    'meta_key' => 'featured',
    "meta_value" => 1,
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
                    <h1>Bogatstvo ponude sezonskog voća i povrća nadohvat ruke.</h1>
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

        <div class="events">
            <ul class="events__list">
                <?php
                    $query = new WP_Query([
                        'post_type' => "post",
                        'post_status' => "publish"
                    ]);
                    $posts = $query->get_posts();
                    foreach ($posts as $p){
                        $image = get_field('image', $p->ID);
                        ?>
                        <li class="events__item">
                            <a href="<?=get_permalink($p->ID)?>">
                                <div class="events__inner" style="background-size:cover;background-image:url(<?=$image['sizes']['large']?>)">
                                    <div style="background-color: rgba(255,255,255,0.3)">
                                        <h2 class="events__content"><?=$p->post_content?></h2>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <?php
                    }
                ?>
            </ul>
        </div>
        
        <?php get_partial('layout/_footer'); ?>
    </main>

<?php

get_footer();
