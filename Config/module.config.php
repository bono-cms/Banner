<?php

/**
 * Module configuration container
 */

return array(
    'caption'  => 'Banner',
    'description' => 'Banner module allows you to manage random banners of different formats on your site',
    'menu' => array(
        'name'  => 'Banner',
        'icon' => 'fab fa-adversal',
        'items' => array(
            array(
                'route' => 'Banner:Admin:Banner@gridAction',
                'name' => 'View all banners'
            ),
            array(
                'route' => 'Banner:Admin:Banner@addAction',
                'name' => 'Add new banner'
            ),
            array(
                'route' => 'Banner:Admin:Category@addAction',
                'name' => 'Add new category'
            )
        )
    )
);