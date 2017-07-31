<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Banner\Controller;

use Cms\Controller\Admin\AbstractController;

final class Target extends AbstractController
{
    /**
     * Visits banner URL
     * 
     * @return string
     */
    public function visitAction()
    {
        // Mandatory parameters
        if ($this->request->hasQuery('id', 'url')) {

            // Request variables
            $id  = $this->request->getQuery('id');
            $url = $this->request->getQuery('url');

            // Increment click count
            $bannerManager = $this->getModuleService('bannerManager');
            $bannerManager->incrementClickCount($id);

            // Redirect to banner's URL
            $this->response->redirect($url);

        } else {
            // Not enough params
        }
    }
}
