<?php

/**
 * This file is part of the Bono CMS
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Banner\Storage;

interface CategoryMapperInterface
{
    /**
     * Fetches all categories
     * 
     * @param boolean $withCount Whether to fetch virtual count field as well
     * @return array
     */
    public function fetchAll($withCount);
}