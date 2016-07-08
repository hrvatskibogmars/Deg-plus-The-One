<?php
/**
 * @var $data array
 */

?>

<div class="products__item">
    <div class="products__image">
        <?php if ($data['isOpg']){ ?>
            <p class="products__opg"><?=$data['isOpg']?></p>
        <?php } ?>
        <img src="<?=$data['slike']['sizes']['large']?>" class="products__source" alt="">
    </div>
    <div class="products__info">
        <h3 class="products__title"><?= $data['title'] ?></h3>
        <p class="products__desc"><?= $data['description'] ?></p>
    </div>
    <div class="products__buy">
        <p class="products__price"><?=$data['price']?></p>
        <a href="#" class="btn btn-red">+ Košarica</a>
    </div>
</div>
