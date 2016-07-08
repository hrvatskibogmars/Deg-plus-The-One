<?php /** Template name: products list */ ?>
<?php

the_post();
get_header();
$ps = new ProductsSearch();
$opg = $ps->getOPGs();
$categories = ProductsSearch::getCategories();
?>
    <main class="main">
        <nav class="navigation">
            <div class="search">
                <form action="#" class="search__form">
                    <input type="text" class="search__input" placeholder="Pretraži">
                    <input type="submit" class="search__submit btn btn-black" value="Pretraži">
                </form>
            </div>
        </nav>
        <div class="horiz">
            <div class="filter">
                <form action="#" class="filter__form">
                    <select>
                        <option value="Kategorija" selected>Kategorija</option>
                        <option value="volvo">Volvo</option>
                        <option value="saab">Saab</option>
                        <option value="mercedes">Mercedes</option>
                        <option value="audi">Audi</option>
                    </select>
                </form>
            </div>
            <div class="filter">
                <form action="#" class="filter__form">
                    <select>
                        <option value="Kategorija" selected>OPG</option>
                        <option value="volvo">Volvo</option>
                        <option value="saab">Saab</option>
                        <option value="mercedes">Mercedes</option>
                        <option value="audi">Audi</option>
                    </select>
                </form>
            </div>
            <ul class="horiz__list">
                <li class="horiz__item">
                    <div class="horiz__image">
                        <img src="static/img/prod2.jpg" alt="" class="horiz__source">
                    </div>
                    <div class="horiz__info">
                        <span class="horiz__type">OPG</span>
                        <p class="horiz__title">OPG1</p>
                        <p class="horiz__desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit. At atque consequatur cupiditate, earum eligendi</p>
                    </div>
                    <div class="horiz__contact horiz__basket">
                        <a href="#" class="btn-red btn horiz__btn">+ Košarica</a>
                    </div>
                </li>
            </ul>
            <div class="load-more">
                <a href="#" class="load-more__anchor btn btn-black">Učitaj više</a>
            </div>
        </div>
    </main>

<?php
get_footer();