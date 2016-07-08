<?php /** Template name: Licitation  */?>
<?php

the_post();

get_header();

$tables = [
    [
        "size" => 10,
        "tables" => [
            ["minPrice" => 100],
            ["minPrice" => 100],
            ["minPrice" => 200],
            ["minPrice" => 200],
            ["minPrice" => 300],
            ["minPrice" => 300],
            ["minPrice" => 200],
            ["minPrice" => 200],
            ["minPrice" => 100],
            ["minPrice" => 100],
        ]
    ],
    [
        "size" => 10,
        "tables" => [
            ["minPrice" => 100],
            ["minPrice" => 100],
            ["minPrice" => 200],
            ["minPrice" => 200],
            ["minPrice" => 300],
            ["minPrice" => 300],
            ["minPrice" => 200],
            ["minPrice" => 200],
            ["minPrice" => 100],
            ["minPrice" => 100],
        ]
    ],
    [
        "size" => 10,
        "tables" => [
            ["minPrice" => 100],
            ["minPrice" => 100],
            ["minPrice" => 200],
            ["minPrice" => 200],
            ["minPrice" => 300],
            ["minPrice" => 300],
            ["minPrice" => 200],
            ["minPrice" => 200],
            ["minPrice" => 100],
            ["minPrice" => 100],
        ]
    ],

]

?>
    <main class="main p-bidding">
        <nav class="navigation">
            <?php get_partial('layout/user-navigation')?>
        </nav>
        <div class="cover">
            <div class="cover__image">
                <div class="cover__text">
                    <h1>Odaberite stol i definirajte licitaciju</h1>
                </div>
            </div>
        </div>
        <div class="reset">
            <div class="reset__inner">
                <a href="#" class="reset__anchor">Poništi odabir</a>
            </div>
        </div>
        <div class="tables">
            <?php
                $counter = 0;
                foreach($tables as $index => $row) {
                    ?>
            <ul class="tables__list tables-top <?=$index == 1 ? "tables__list--offset" : ""?>">
                    <?php
                        foreach ($row['tables'] as $table) {
                            $counter++;
                            ?>
                            <li class="tables__item tables__item-top">
                                <a href="#" class="tables__anchor" data-id="<?=$counter?>" data-min="<?=$table['minPrice']?>">
                                    <div class="tables__label"></div>
                                    <div class="tables__info">
                                        <h2 class="tables__position">
                                            Stol broj <?=$counter?>
                                        </h2>
                                        <h3 class="tables__pricing">Min. cijena</h3>
                                        <p class="tables__price"><?=$table['minPrice']?>kn</p>
                                    </div>
                                    <div class="tables__order">
                                        Izaberi stol
                                    </div>
                                </a>
                            </li>
                            <?php
                        }
                    ?>
                </ul>
                <?php
                }
            ?>
        </div>
        <div class="offer">
            <form action="#" class="offer__form">
                <input type="number" class="offer__input" placeholder="Iznos">
                <input type="submit" class="offer__submit btn btn-red" value="Licitiraj">
            </form>
        </div>
        <?php get_partial('layout/_footer'); ?>
    </main>
    <div class="remodal remodal-thanks" data-remodal-id="thanks">
        <button data-remodal-action="close" class="remodal-close"></button>
        <h1 class="thank-you__title">Licitacija uspješna</h1>
        <p class="thank-you__text">
            Uspješno ste postavili licitaciju za odabrane stolove
        </p>
        <br>
        <button data-remodal-action="confirm" class="remodal-confirm">Zatvori</button>
    </div>
<?php
get_footer();