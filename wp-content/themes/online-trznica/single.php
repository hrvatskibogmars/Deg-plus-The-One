<?php

the_post();
get_header();

$imageObj = get_field('image', get_the_ID());
$image = $imageObj['sizes']['large'];
?>
    <main class="main p-home">
        <nav class="navigation">
            <a href="/registracija" class="btn btn-black">Registriraj se</a>
        </nav>
        <div class="cover" style="background-image: url(<?=$image?>);height:300px">
            <div class="cover__image">
                <div class="cover__text">
                    <h1><?=get_the_title()?></h1>
                </div>
            </div>
        </div>
        <div class="single">
            <p class="single__text">
                <?=get_the_content()?>
            </p>

        </div>
        <?php get_partial('layout/_footer'); ?>
    </main>

<?php

get_footer();
