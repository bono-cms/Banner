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
    
    '/admin/module/banner' => array(
        'controller' => 'Admin:Banner@gridAction'
    ),
    
    '/admin/module/banner/page/(:var)' => array(
        'controller' => 'Admin:Banner@gridAction'
    ),
    
    '/admin/module/banner/delete/(:var)' => array(
        'controller' => 'Admin:Banner@deleteAction',
        'disallow' => array('guest')
    ),
    
    '/admin/module/banner/add' => array(
        'controller' => 'Admin:Banner@addAction'
    ),
    
    '/admin/module/banner/edit/(:var)'  =>  array(
        'controller' => 'Admin:Banner@editAction'
    ),
    
    '/admin/module/banner/save' => array(
        'controller' => 'Admin:Banner@saveAction',
        'disallow' => array('guest')
    )
);
