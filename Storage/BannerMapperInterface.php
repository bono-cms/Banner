<?php

/**
 * This file is part of the Bono CMS
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Banner\Storage;

interface BannerMapperInterface
{
    /**
     * Returns current time
     * 
     * @return string
     */
    public function getCurrentTime();

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
     * Fetches banner name by its associated ID
     * 
     * @param string $id Banner ID
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
     * @param array $validIds Optional collection of valid IDs to restrict output
     * @return array
     */
    public function fetchAllByPage($page, $itemsPerPage, $categoryId, array $validIds = []);

    /**
     * Fetches random banner
     * 
     * @param string $categoryId Optional category ID filter
     * @param array $validIds Optional collection of valid IDs to restrict output
     * @return array
     */
    public function fetchRandom($categoryId, array $validIds = []);

    /**
     * Fetches banner data by its associated ID
     * 
     * @param string $id Banner ID
     * @return array
     */
    public function fetchById($id);

    /**
     * Deletes a banner by its associated ID
     * 
     * @param string $id Banner ID
     * @return boolean
     */
    public function deleteById($id);
}