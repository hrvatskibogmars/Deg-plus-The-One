<footer class="wrapper footer__wrapper">
    <div class="footer container">
        <div class="logo__wrapper">
            <span class="logo__el">
                <a href="<?= get_site_url() ?>">
                    <? _e('The Truffle', 'truffle') ?>
                    <i class="logo__subtitle">
                        <? _e('Ultimate Croatian Restaurant & Wine Guide', 'truffle') ?>
                    </i>
                </a>
            </span>
        </div>
        <nav class="main-navigation main-navigation--footer">
            <ul>
                <li>
<!--                    <a href="--><?//= get_field('about_page', 'options') ?><!--">--><?// _e('About us', 'truffle') ?><!--</a>-->
                </li>
            </ul>
        </nav>
    </div>
    <?php wp_footer(); ?>
</footer>