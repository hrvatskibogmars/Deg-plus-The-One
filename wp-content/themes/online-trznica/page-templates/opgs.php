<?php /** Template name: OPGs */?>
<?php
the_post();

get_header();

$categories = ProductsSearch::getCategories();

$os = new OPGSearch();
$opgs = $os->search();

?>

    <main class="main">
        <nav class="navigation">
            <?php get_partial('layout/user-navigation')?>
        </nav>
        <div class="horiz">
            <h1 class="horiz__heading">OPG-ovi</h1>
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
            <ul class="horiz__list">
                <?php
                    foreach($opgs as $opg) {
                        get_partial('opgs/item', array("data" => getOPGData($opg)));
                    }
                ?>
            </ul>
            <div class="load-more">
                <a href="#" class="load-more__anchor btn btn-black">Učitaj više</a>
            </div>
        </div>
        <?php get_partial('layout/_footer'); ?>
    </main>



<?php
get_footer();