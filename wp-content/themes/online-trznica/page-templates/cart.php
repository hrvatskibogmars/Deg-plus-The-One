<?php /** Template name: Cart */?>
<?php

if(isset($_REQUEST['buy'])){
    $cart = Cart::getForUser();
    $cart->setData([]);
    $cart->save();

    wp_redirect('/proizvodi');
}

$cart = Cart::getForUser();
$user = get_current_user_id();
if(!$cart){
    $cart = new Cart();
    $cart->setUserId( $user );
    $cart->setData([]);
}

if(isset($_REQUEST['productId'])){
    $insertIntoCart = $_REQUEST['productId'];

    $data = $cart->getData();
    if(!isset($data[ $insertIntoCart ])) {
        $data[ $insertIntoCart ] = 1;
    }

    $cart->setData($data);
}

$cart->save();

$products = $cart->getData();

the_post();

get_header();

?>

    <main class="main">
        <nav class="navigation">

        </nav>
        <div class="horiz horiz__cart">
            <h1 class="horiz__heading">Košarica</h1>
            <ul class="horiz__list">
                <?php
                    foreach ($products as $id => $amount){
                        $p = WP_Post::get_instance($id);
                        $pData = getProductData($p);
                        ?>
                        <li class="horiz__item">
                            <div class="horiz__image">
                                <img src="<?=$pData['slike']['sizes']['large']?>" alt="" class="horiz__source">
                            </div>
                            <div class="horiz__info">
                                <p class="horiz__title"><?=$pData['title']?></p>
                                <p class="horiz__desc"><?=$pData['short_description']?></p>
                            </div>
                            <div class="horiz__contact horiz__basket">
                                <span class="basket__price"><?=get_field('price', $p->ID)?></span>
                                <form action="#" class="basket__form">
                                    <label class="basket__label" for="">Količina</label>
                                    <input class="basket__input" type="text" value="<?=$amount?>" data-id="<?=$id?>">
                                </form>
                            </div>
                        </li>
                        <?php
                    }
                ?>
            </ul>
            <div class="total">
                <p class="total__inner">Ukupno <span class="total__amount">11kn</span></p>
                <form action="" class="basket__send">
                    <input type="hidden" name="buy" value="1" >
                    <input class="basket__submit  btn btn-black" type="submit"  value="Kupi">
                </form>
            </div>
        </div>
    </main>


<?php

get_footer();
