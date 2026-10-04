<?php

/**
 * This file is part of the Bono CMS
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

return [
    '/module/banner/target/(:var)' => [
        'controller' => 'Target@visitAction'
    ],
    
    '/%s/module/banner' => [
        'controller' => 'Admin:Banner@gridAction'
    ],
    
    '/%s/module/banner/category/view/(:var)' => [
        'controller' => 'Admin:Banner@categoryAction'
    ],

    '/%s/module/banner/category/view/(:var)/page/(:var)' => [
        'controller' => 'Admin:Banner@categoryAction'
    ],
    
    '/%s/module/banner/category/add' => [
        'controller' => 'Admin:Category@addAction'
    ],

    '/%s/module/banner/category/edit/(:var)' => [
        'controller' => 'Admin:Category@editAction'
    ],

    '/%s/module/banner/category/delete/(:var)' => [
        'controller' => 'Admin:Category@deleteAction'
    ],

    '/%s/module/banner/category/save' => [
        'controller' => 'Admin:Category@saveAction'
    ],
    
    '/%s/module/banner/page/(:var)' => [
        'controller' => 'Admin:Banner@gridAction'
    ],
    
    '/%s/module/banner/delete/(:var)' => [
        'controller' => 'Admin:Banner@deleteAction',
        'disallow' => ['guest']
    ],
    
    '/%s/module/banner/add' => [
        'controller' => 'Admin:Banner@addAction'
    ],
    
    '/%s/module/banner/edit/(:var)' => [
        'controller' => 'Admin:Banner@editAction'
    ],
    
    '/%s/module/banner/save' => [
        'controller' => 'Admin:Banner@saveAction',
        'disallow' => ['guest']
    ]
];