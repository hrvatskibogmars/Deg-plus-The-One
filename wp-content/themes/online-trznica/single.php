<?php

the_post();
get_header();
$postDetails = get_fields();
get_partial('article', $postDetails, false , 'post-templates');

get_footer();
