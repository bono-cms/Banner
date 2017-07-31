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
     * Increments entity view count
     * 
     * @param mixed $entity
     * @return void
     */
    private function incrementViewCount($entity)
    {
        if ($entity !== false) {
            $this->bannerManager->incrementViewCount($entity->getId());
        }
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
            $entity = $this->bannerManager->fetchRandom($category['id']);

            // Add only if there's at least one banner in current category
            if ($entity !== false) {
                $banners[] = $entity;

                // Increment view count
                $this->incrementViewCount($entity);
            }
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
        $entity = $this->bannerManager->fetchRandom($categoryId);

        // Increment view count
        $this->incrementViewCount($entity);
        return $entity;
    }

    /**
     * Returns banner's entity by its associated id, or false on failure
     * 
     * @param string $id Banner id
     * @return \Krystal\Stdlib\VirtualEntity|boolean
     */
    public function getById($id)
    {
        $entity = $this->bannerManager->fetchById($id);

        // Increment view count
        $this->incrementViewCount($entity);
        return $entity;
    }
}
