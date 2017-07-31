<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Banner\Storage;

interface BannerMapperInterface
{
    /**
     * Increments view count by banner ID
     * 
     * @param string $id
     * @return boolean
     */
    public function incrementViewCount($id);

    /**
     * Increments click count by banner ID
     * 
     * @param string $id
     * @return boolean
     */
    public function incrementClickCount($id);

    /**
     * Fetches banner name by its associated id
     * 
     * @param string $id Banner id
     * @return string
     */
    public function fetchNameById($id);

    /**
     * Updates a banner
     * 
     * @param array $data
     * @return boolean Depending on success
     */
    public function update(array $data);

    /**
     * Inserts a banner
     * 
     * @param array $data
     * @return boolean Depending on success
     */
    public function insert(array $data);

    /**
     * Fetches all banners filtered by pagination
     * 
     * @param integer $page Current page
     * @param string $itemsPerPage Per page count
     * @param string $categoryId Optional category ID filter
     * @return array
     */
    public function fetchAllByPage($page, $itemsPerPage, $categoryId);

    /**
     * Fetches random banner
     * 
     * @param string $categoryId Optional category ID filter
     * @return array
     */
    public function fetchRandom($categoryId);

    /**
     * Fetches banner's data by its associated id
     * 
     * @param string $id Banner id
     * @return array
     */
    public function fetchById($id);

    /**
     * Deletes a banner by its associated id
     * 
     * @param string $id Banner id
     * @return boolean
     */
    public function deleteById($id);
}
