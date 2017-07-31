<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

return array(
    '/module/banner/target/(:var)' => array(
        'controller' => 'Target@visitAction'
    ),
    
    '/%s/module/banner' => array(
        'controller' => 'Admin:Banner@gridAction'
    ),
    
    '/%s/module/banner/category/view/(:var)' => array(
        'controller' => 'Admin:Banner@categoryAction'
    ),

    '/%s/module/banner/category/view/(:var)/page/(:var)' => array(
        'controller' => 'Admin:Banner@categoryAction'
    ),
    
    '/%s/module/banner/category/add' => array(
        'controller' => 'Admin:Category@addAction'
    ),

    '/%s/module/banner/category/edit/(:var)' => array(
        'controller' => 'Admin:Category@editAction'
    ),

    '/%s/module/banner/category/delete/(:var)' => array(
        'controller' => 'Admin:Category@deleteAction'
    ),

    '/%s/module/banner/category/save' => array(
        'controller' => 'Admin:Category@saveAction'
    ),
    
    '/%s/module/banner/page/(:var)' => array(
        'controller' => 'Admin:Banner@gridAction'
    ),
    
    '/%s/module/banner/delete/(:var)' => array(
        'controller' => 'Admin:Banner@deleteAction',
        'disallow' => array('guest')
    ),
    
    '/%s/module/banner/add' => array(
        'controller' => 'Admin:Banner@addAction'
    ),
    
    '/%s/module/banner/edit/(:var)'  =>  array(
        'controller' => 'Admin:Banner@editAction'
    ),
    
    '/%s/module/banner/save' => array(
        'controller' => 'Admin:Banner@saveAction',
        'disallow' => array('guest')
    )
);