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
		'controller' => 'Admin:Browser@indexAction'
	),
	
	'/admin/module/banner/page/(:var)' => array(
		'controller' => 'Admin:Browser@indexAction'
	),
	
	'/admin/module/banner/delete.ajax' => array(
		'controller' => 'Admin:Browser@deleteAction',
		'disallow' => array('guest')
	),
	
	'/admin/module/banner/delete-selected.ajax' => array(
		'controller' => 'Admin:Browser@deleteSelectedAction'
	),
	
	'/admin/module/banner/add' => array(
		'controller' => 'Admin:Add@indexAction'
	),
	
	'/admin/module/banner/add.ajax' => array(
		'controller' => 'Admin:Add@addAction',
		'disallow' => array('guest')
	),
	
	'/admin/module/banner/edit/(:var)'	=>	array(
		'controller' => 'Admin:Edit@indexAction'
	),
	
	'/admin/module/banner/edit.ajax' => array(
		'controller' => 'Admin:Edit@updateAction',
		'disallow' => array('guest')
	)
);
