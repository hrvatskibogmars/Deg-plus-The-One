<?php /** Template name: products list */ ?>
<?php

the_post();
get_header();
$ps = new ProductsSearch();
$products = $ps->search();

$opgs = $ps->getOPGs();
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
                        <option value="0" selected>Kategorija</option>
                        <?php
                        foreach($categories as $category) {
                            echo '<option value="'.$category->slug.'">'.$category->name.'</option>';
                        }
                        ?>
                    </select>
                </form>
            </div>
            <div class="filter">
                <form action="#" class="filter__form">
                    <select>
                        <option value="0" selected>OPG</option>
                        <?php
                        foreach($opgs as $id => $name) {
                            echo '<option value="'.$id.'">'.$name.'</option>';
                        }
                        ?>
                    </select>
                </form>
            </div>
            <ul class="horiz__list">
                <?php
                    foreach ($products as $product){
                        get_partial('products/listing-item', ['data' => getProductData($product)]);
                    }
                ?>
            </ul>
            <div class="load-more">
                <a href="#" class="load-more__anchor btn btn-black">Učitaj više</a>
            </div>
        </div>
    </main>

<?php
get_footer();