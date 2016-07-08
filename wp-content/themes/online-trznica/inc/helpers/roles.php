<?php

add_role(
    'Korisnik',
    __( 'Korisnik' ),
    array(
        'read_products'                 => true,  // true allows this capability
        'publish_products'              => true,  // true allows this capability
        'edit_products'                 => true,
        'delete_published_products'     => true, // Use false to explicitly deny
    )
);