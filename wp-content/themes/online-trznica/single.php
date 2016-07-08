<?php

the_post();
get_header();

?>
    <main class="main p-home">
        <nav class="navigation">
            <a href="/registracija" class="btn btn-black">Registriraj se</a>
        </nav>
        <div class="cover">
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
