<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Banner\Service;

use Banner\Storage\CategoryMapperInterface;

final class SiteService implements SiteServiceInterface
{
    /**
     * Banner manager service
     * 
     * @var \Banner\Service\BannerManagerInterface
     */
    private $bannerManager;

    /**
     * Any compliant category mapper
     * 
     * @var \Banner\Storage\CategoryMapperInterface
     */
    private $categoryMapper;

    /**
     * State initialization
     * 
     * @param \Banner\Service\BannerManagerInterface $bannerManager
     * @param \Banner\Storage\CategoryMapperInterface $categoryMapper
     * @return void
     */
    public function __construct(BannerManagerInterface $bannerManager, CategoryMapperInterface $categoryMapper)
    {
        $this->bannerManager = $bannerManager;
        $this->categoryMapper = $categoryMapper;
    }

    /**
     * Fetch all banners from available categories in random order
     * 
     * @return array
     */
    public function getAll()
    {
        $banners = array();

        foreach ($this->categoryMapper->fetchAll(false) as $category) {
            $banners[] = $this->getRandom($category['id']);
        }

        return $banners;
    }

    /**
     * Returns random banner's entity
     * 
     * @param string $categoryId Optional category ID filter
     * @return \Krystal\Stdlib\VirtualEntity
     */
    public function getRandom($categoryId = null)
    {
        return $this->bannerManager->fetchRandom($categoryId);
    }

    /**
     * Returns banner's entity by its associated id, or false on failure
     * 
     * @param string $id Banner id
     * @return \Krystal\Stdlib\VirtualEntity|boolean
     */
    public function getById($id)
    {
        return $this->bannerManager->fetchById($id);
    }
}
