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

interface SiteServiceInterface
{
    /**
     * Fetch all banners from available categories in random order
     * 
     * @return array
     */
    public function getAll();

    /**
     * Returns random banner's entity
     * 
     * @param string $categoryId Optional category ID filter
     * @return \Krystal\Stdlib\VirtualEntity
     */
    public function getRandom($categoryId = null);

    /**
     * Returns banner's entity by its associated id, or false on failure
     * 
     * @param string $id Banner id
     * @return \Krystal\Stdlib\VirtualEntity|boolean
     */
    public function getById($id);
}
