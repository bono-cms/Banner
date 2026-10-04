<?php

/**
 * Module configuration container
 */

return [
    'caption' => 'Banner',
    'description' => 'Banner module allows you to manage random banners of different formats on your site',
    'menu' => [
        'name' => 'Banner',
        'icon' => 'fab fa-adversal',
        'items' => [
            [
                'route' => 'Banner:Admin:Banner@gridAction',
                'name' => 'View all banners'
            ],
            [
                'route' => 'Banner:Admin:Banner@addAction',
                'name' => 'Add new banner'
            ],
            [
                'route' => 'Banner:Admin:Category@addAction',
                'name' => 'Add new category'
            ]
        ]
    ]
];