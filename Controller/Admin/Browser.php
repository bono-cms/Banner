<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Banner\Controller\Admin;

final class Browser extends AbstractAdminController
{
	/**
	 * Shows a table
	 * 
	 * @param string $page Current page
	 * @return string
	 */
	public function indexAction($page = 1)
	{
		$bannerManager = $this->getBannerManager();

		$this->loadPlugins();

		$paginator = $bannerManager->getPaginator();
		$paginator->setUrl('/admin/module/banner/page/(:var)');

		return $this->view->render('browser', array(
			'banners' => $bannerManager->fetchAllByPage($page, $this->getSharedPerPageCount()),
			'paginator' => $paginator,
			'title' => 'Banner',
		));
	}

	/**
	 * Loads required plugins for view
	 * 
	 * @return void
	 */
	private function loadPlugins()
	{
		$this->view->getPluginBag()
				   ->appendScript($this->getWithAssetPath('/admin/browser.js'));

		$this->view->getBreadcrumbBag()->add(array(
			array(
				'link' => '#',
				'name' => 'Banner'
			)
		));
	}

	/**
	 * Deletes a banner by its associated id
	 * 
	 * @return string The response
	 */
	public function deleteAction()
	{
		if ($this->request->hasPost('id')) {

			$id = $this->request->getPost('id');

			if ($this->getBannerManager()->deleteById($id)) {

				$this->flashBag->set('success', 'A banner has been removed successfully');
				return '1';
			}
		}
	}

	/**
	 * Delete selected records
	 * 
	 * @return string The response
	 */
	public function deleteSelectedAction()
	{
		if ($this->request->hasPost('toDelete')) {

			$ids = array_keys($this->request->getPost('toDelete'));

			$this->getBannerManager()->deleteByIds($ids);
			$this->flashBag->set('success', 'Selected banners have been removed successfully');

		} else {

			$this->flashBag->set('warning', 'You should select at least one banner to remove');
		}

		return '1';
	}
}