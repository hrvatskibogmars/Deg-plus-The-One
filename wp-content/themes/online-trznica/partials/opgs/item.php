<?php
/**
 * @var $data array
 */

?>

<li class="horiz__item">
    <div class="horiz__image">
        <img src="<?=$data['profile_image']['sizes']['large']?>" alt="" class="horiz__source">
    </div>
    <div class="horiz__info">
        <span class="horiz__type">OPG</span>
        <p class="horiz__title"><?=$data['title']?></p>
        <p class="horiz__desc"><?=$data['short_description']?></p>
    </div>
    <div class="horiz__contact">
        <?php
            $address = explode(",", $data['address']);
        ?>
        <p><?= $address[0] ?></p>
        <p><?= $address[1] ?></p>
        <a href="mailto:<?=$data['email']?>?Subject=Kontakt (Online tržnica)">Pošalji email</a>
    </div>
</li>
