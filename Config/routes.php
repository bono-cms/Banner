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
    '/%s/module/banner' => array(
        'controller' => 'Admin:Banner@gridAction'
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