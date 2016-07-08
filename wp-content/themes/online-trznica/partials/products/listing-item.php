<?php
/**
 * @var $data array
 */?>


<li class="horiz__item">
    <div class="horiz__image">
        <img src="<?=$data['slike']['sizes']['large']?>" alt="" class="horiz__source">
    </div>
    <div class="horiz__info">
        <p class="horiz__title"><?=$data['title']?></p>
        <p class="horiz__desc"><?=$data['short_description']?></p>
    </div>
    <div class="horiz__contact horiz__basket">
        <a href="#" class="btn-red btn horiz__btn">+ Košarica</a>
    </div>
</li>
