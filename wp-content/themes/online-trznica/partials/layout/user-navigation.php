<?php
/**
 * Created by PhpStorm.
 * User: vilimstubican
 * Date: 08/07/16
 * Time: 14:24
 */


if(!is_user_logged_in()) {
    ?>
    <a href="/sign-up" class="btn btn-black">Registriraj se</a>
<?php
} else {
    $user = wp_get_current_user();
 ?>
    <a href="<?=get_edit_profile_url( $user->ID )?>" class="btn btn-black">Moj profil</a>
    <a href="<?=wp_logout_url( get_site_url() )?>" class="btn btn-black">Odjavite se</a>
<?php
}


