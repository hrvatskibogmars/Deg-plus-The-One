<?php /** Template name: products list */ ?>
<?php

the_post();

$ps = new ProductsSearch();
$opg = $ps->getOPGs();
