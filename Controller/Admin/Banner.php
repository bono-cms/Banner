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
     * Creates a grid
     * 
     * @param string $url Banner's URL
     * @param string $page Current page
     * @param string $categoryId Optional category ID filter
     * @return string
     */
    private function createGrid($url, $page, $categoryId)
    {
        // Append a breadcrumb
        $this->view->getBreadcrumbBag()
                   ->addOne('Banner');

        $bannerManager = $this->getModuleService('bannerManager');

        // Configure paginator instance
        $paginator = $bannerManager->getPaginator();
        $paginator->setUrl($url);

        return $this->view->render('browser', array(
            'banners' => $bannerManager->fetchAllByPage($page, $this->getSharedPerPageCount(), $categoryId),
            'paginator' => $paginator,
            'categories' => $this->getModuleService('categoryManager')->fetchAll(),
            'categoryId' => $categoryId
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
        $this->view->getPluginBag()
                   ->load('datetimepicker');

        // Append a breadcrumb
        $this->view->getBreadcrumbBag()->addOne('Banner', 'Banner:Admin:Banner@gridAction')
                                       ->addOne($title);

        return $this->view->render('banner.form', array(
            'banner' => $banner,
            'expirationTypes' => $this->getModuleService('bannerManager')->getExpirationTypes(),
            'categories' => $this->getModuleService('categoryManager')->fetchList()
        ));
    }

    /**
     * Renders the category
     * 
     * @param string $categoryId
     * @param string $page Current page
     * @return string
     */
    public function categoryAction($categoryId, $page = 1)
    {
        return $this->createGrid($this->createUrl('Banner:Admin:Banner@categoryAction', array($categoryId), 1), $page, $categoryId);
    }

    /**
     * Renders a grid
     * 
     * @param string $page Current page
     * @return string
     */
    public function gridAction($page = 1)
    {
        return $this->createGrid($this->createUrl('Banner:Admin:Banner@gridAction', array(), 1), $page, null);
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
            return $this->createForm($banner, $this->translator->translate('Edit the banner "%s"', $banner->getName()));
        } else {
            return false;
        }
    }

    /**
     * Deletes a banner by its associated id
     * 
     * @param string $id
     * @return string The response
     */
    public function deleteAction($id)
    {
        $historyService = $this->getService('Cms', 'historyManager');
        $service = $this->getModuleService('bannerManager');

        // Batch removal
        if ($this->request->hasPost('batch')) {
            $ids = array_keys($this->request->getPost('batch'));

            $service->deleteByIds($ids);
            $this->flashBag->set('success', 'Selected elements have been removed successfully');

            // Track in the history
            $historyService->write('Banner', 'Batch removal of %s banner', count($ids));

        } else {
            $this->flashBag->set('warning', 'You should select at least one element to remove');
        }

        // Single removal
        if (!empty($id)) {
            $banner = $this->getModuleService('bannerManager')->fetchById($id);

            $service->deleteById($id);
            $this->flashBag->set('success', 'Selected element has been removed successfully');

            // Track in the history
            $historyService->write('Banner', 'Banner "%s" has been removed', $banner->getName());
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

        $formValidator = $this->createValidator(array(
            'input' => array(
                'source' => $input,
                'definition' => array(
                    'name' => new Pattern\Name(),
                    'link' => new Pattern\Url(),
                )
            ),
            'file' => array(
                'source' => $this->request->getFiles(),
                'definition' => $this->request->hasFiles('banner') ? array(
                    'banner' => new Pattern\File(array(
                        'required' => !$input['id']
                    ))
                ) : array()
            )
        ));

        if ($formValidator->isValid()) {
            $historyService = $this->getService('Cms', 'historyManager');
            $service = $this->getModuleService('bannerManager');

            if (!empty($input['id'])) {
                if ($service->update($this->request->getAll())) {
                    $this->flashBag->set('success', 'The element has been updated successfully');
                    // Save in the history
                    $historyService->write('Banner', 'Banner %s has been updated', $input['name']);

                    return '1';
                }

            } else {
                if ($service->add($this->request->getAll())) {
                    $this->flashBag->set('success', 'The element has been created successfully');

                    // Save in the history
                    $historyService->write('Banner', 'Banner "%s" has been uploaded', $input['name']);

                    return $service->getLastId();
                }
            }

        } else {
            return $formValidator->getErrors();
        }
    }
}
