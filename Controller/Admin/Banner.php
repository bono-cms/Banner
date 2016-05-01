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
        // Append a breadcrumb
        $this->view->getBreadcrumbBag()
                   ->addOne('Banner');

        $bannerManager = $this->getModuleService('bannerManager');
        $paginator = $bannerManager->getPaginator();
        $paginator->setUrl($this->createUrl('Banner:Admin:Banner@gridAction', array(), 1));

        return $this->view->render('browser', array(
            'banners' => $bannerManager->fetchAllByPage($page, $this->getSharedPerPageCount()),
            'paginator' => $paginator
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
     * @param string $id
     * @return string The response
     */
    public function deleteAction($id)
    {
        return $this->invokeRemoval('bannerManager', $id);
    }

    /**
     * Persists a banner
     * 
     * @return string
     */
    public function saveAction()
    {
        $input = $this->request->getPost('banner');

        return $this->invokeSave('bannerManager', $input['id'], $this->request->getAll(), array(
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
    }
}
