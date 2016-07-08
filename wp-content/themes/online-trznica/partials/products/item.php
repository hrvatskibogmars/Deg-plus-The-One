<?php
/**
 * @var $data array
 */

?>

<div class="products__item">
    <div class="products__image">
        <img src="<?=$data['slike']['0']['sizes']['large']?>" class="products__source" alt="">
    </div>
    <div class="products__info">
        <h3 class="products__title"><?= $data['title'] ?></h3>
        <p class="products__desc"><?= $data['short_description'] ?></p>
    </div>
    <div class="products__buy">
        <p class="products__price"><?=$data['price']?></p>
        <a href="#" class="btn btn-red">Naruči</a>
    </div>
</div>
