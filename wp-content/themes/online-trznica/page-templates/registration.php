<?php /** Template Name: Registration */ ?>
<?php
the_post();
get_header();

?>
    <main class="main">
        <div class="signup p-full">
            <div class="signup__container">
                <div class="signup__data">
                    <div class="signup__header header">
                        <div class="header__left">
                            <h2>Registrirajte se!</h2>
                        </div>
                        <div class="header__right">
                            <p>Klikom do svježeg voća i povrća.</p>
                        </div>
                    </div>
                    <div class="signup__inner">
                        <?= the_content(); ?>
                    </div>
                </div>
                <div class="signup__cover">
                    <div class="signup__image">
                        <img src="<?= bu("img/form.jpg")?>" alt="" class="signup__source">
                    </div>
                </div>
            </div>

        </div>

    </main>

<?php
get_footer();

