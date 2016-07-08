This folder is base for page templates. It couples partials into one structur.


You can create template page by simply adding following line to the top of the file:

        <?php /* Template Name: Name for Your template */ ?>




Following is a demonstration of one template page:

<?php /** Template Name: About us */ ?>
<?php
    get_header('full');

    // Fetch all ACF fields for current page.
    $data = get_fields();

    // Intro
    get_partial('about/intro', array( 'data' => $data));

    // Location
    get_partial('about/location', array( 'data' => $data));

    // History
    get_partial('about/history', array( 'data' => $data));

    // Partners
    get_partial('about/partners', array( 'data' => $data));

    // Contact
    get_partial('about/contact', array( 'data' => $data));

    // Newsletter
    get_partial('about/newsletter', array( 'data' => $data));

    get_footer();





Basic parts of any template in Wordpress is get_header() and get_footer().
If no arguments is supplied, they will target header.php and footer.php in the themes folder.
If argument supplied, they will target header-{name}.php and footer-{name}.php.

Examples:
    1) get_header(); => header.php
    2) get_header('full'); => header-full.php
    3) get_footer(); => footer.php
    4) get_footer('full'); => footer-full.php

This way You can organize your code more modular.