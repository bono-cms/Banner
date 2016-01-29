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

use Krystal\Stdlib\VirtualEntity;
use Krystal\Validate\Pattern;
use Cms\Controller\Admin\AbstractController;

final class Banner extends AbstractController
{
    /**
     * Renders a grid
     * 
     * @param string $page Current page
     * @return string
     */
    public function gridAction($page = 1)
    {
        // Load view plugins
        $this->view->getPluginBag()
                   ->appendScript('@Banner/admin/browser.js');

        // Append a breadcrumb
        $this->view->getBreadcrumbBag()->addOne('Banner');

        $bannerManager = $this->getModuleService('bannerManager');
        $paginator = $bannerManager->getPaginator();
        $paginator->setUrl('/admin/module/banner/page/(:var)');

        return $this->view->render('browser', array(
            'banners' => $bannerManager->fetchAllByPage($page, $this->getSharedPerPageCount()),
            'paginator' => $paginator,
            'title' => 'Banner',
        ));
    }

    /**
     * Creates a form
     * 
     * @param \Krystal\Stdlib\VirtualEntity $banner
     * @param string $title
     * @return string
     */
    private function createForm(VirtualEntity $banner, $title)
    {
        // Load view plugins
        $this->view->getPluginBag()
                   ->appendScript('@Banner/admin/banner.form.js');

        // Append a breadcrumb
        $this->view->getBreadcrumbBag()->addOne('Banner', 'Banner:Admin:Banner@gridAction')
                                       ->addOne($title);

        return $this->view->render('banner.form', array(
            'title' => $title,
            'banner' => $banner
        ));
    }

    /**
     * Renders empty form
     * 
     * @return string
     */
    public function addAction()
    {
        return $this->createForm(new VirtualEntity(), 'Add a banner');
    }

    /**
     * Renders edit form
     * 
     * @param string $id
     * @return string
     */
    public function editAction($id)
    {
        $banner = $this->getModuleService('bannerManager')->fetchById($id);

        if ($banner !== false) {
            return $this->createForm($banner, 'Edit the banner');
        } else {
            return false;
        }
    }

    /**
     * Deletes a banner by its associated id
     * 
     * @return string The response
     */
    public function deleteAction()
    {
        $bannerManager = $this->getModuleService('bannerManager');

        // Batch removal
        if ($this->request->hasPost('toDelete')) {
            $ids = array_keys($this->request->getPost('toDelete'));

            $bannerManager->deleteByIds($ids);
            $this->flashBag->set('success', 'Selected banners have been removed successfully');
        } else {
            $this->flashBag->set('warning', 'You should select at least one banner to remove');
        }

        // Single removal
        if ($this->request->hasPost('id')) {
            $id = $this->request->getPost('id');

            if ($bannerManager->deleteById($id)) {
                $this->flashBag->set('success', 'A banner has been removed successfully');
            }
        }

        return '1';
    }

    /**
     * Persists a banner
     * 
     * @return string
     */
    public function saveAction()
    {
        $input = $this->request->getPost('banner');

        $formValidator = $this->validatorFactory->build(array(
            'input' => array(
                'source' => $input,
                'definition' => array(
                    'name' => new Pattern\Name(),
                    'link' => new Pattern\Url(),
                )
            ),
            'file' => array(
                'source' => $this->request->getFiles(),
                'definition' => array(
                    'banner' => new Pattern\File(array(
                        'required' => !$input['id']
                    ))
                )
            )
        ));

        if ($formValidator->isValid()) {
            $bannerManager = $this->getModuleService('bannerManager');
            
            if ($input['id']){
                if ($bannerManager->update($this->request->getAll())) {
                    $this->flashBag->set('success', 'A banner has been updated successfully');
                    return '1';
                }
            } else {
                if ($bannerManager->add($this->request->getAll())) {
                    $this->flashBag->set('success', 'A banner has been added successfully');
                    return $bannerManager->getLastId();
                }
            }
            
        } else {
            return $formValidator->getErrors();
        }
    }
}
