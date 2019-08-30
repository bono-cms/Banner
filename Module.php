<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Banner;

use Krystal\Http\FileTransfer\DirectoryBag;
use Krystal\Http\FileTransfer\UrlPathGenerator;
use Cms\AbstractCmsModule;
use Banner\Service\CategoryManager;
use Banner\Service\BannerManager;
use Banner\Service\SiteService;

final class Module extends AbstractCmsModule
{
    /**
     * {@inheritDoc}
     */
    public function getServiceProviders()
    {
        $dirBag = new DirectoryBag($this->appConfig->getModuleUploadsDir('banner'));
        $pathGenerator = new UrlPathGenerator('/data/uploads/module/banner');

        // Mappers
        $bannerMapper = $this->getMapper('/Banner/Storage/MySQL/BannerMapper');
        $categoryMapper = $this->getMapper('/Banner/Storage/MySQL/CategoryMapper');

        $bannerManager = new BannerManager($bannerMapper, $dirBag, $pathGenerator);
        $categoryManager = new CategoryManager($categoryMapper);

        return array(
            'bannerManager' => $bannerManager,
            'categoryManager' => $categoryManager,
            'siteService' => new SiteService($bannerManager, $categoryMapper)
        );
    }
}
