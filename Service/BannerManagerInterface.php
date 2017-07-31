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

/* API for Banner Manager */
interface BannerManagerInterface
{
    /**
     * Returns expiration types
     * 
     * @return array
     */
    public function getExpirationTypes();

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
     * Returns prepared paginator's instance
     * 
     * @return \Krystal\Paginate\Paginator
     */
    public function getPaginator();

    /**
     * Returns last banner's id
     * 
     * @return integer
     */
    public function getLastId();

    /**
     * Fetches all banner entities filtered by pagination
     * 
     * @param string $page Current page
     * @param string $itemsPerPage Per page count
     * @param string $categoryId Optional category ID filter
     * @return array An array of banner entities
     */
    public function fetchAllByPage($page, $itemsPerPage, $categoryId = null);

    /**
     * Fetches random banner's entity
     * 
     * @param string $categoryId Optional category ID filter
     * @return \Krystal\Stdlib\VirtualEntity
     */
    public function fetchRandom($categoryId = null);

    /**
     * Fetches banner's entity by its associated id
     * 
     * @param string $id Banner id
     * @return boolean|\Krystal\Stdlib\VirtualEntity|boolean
     */
    public function fetchById($id);

    /**
     * Adds a banner
     * 
     * @param array $input Raw form input
     * @return boolean
     */
    public function add(array $form);

    /**
     * Updates a banner
     * 
     * @param array $input Raw form input
     * @return boolean
     */
    public function update(array $input);

    /**
     * Deletes a banner by its associated id
     * 
     * @param string $id Banner id
     * @return boolean
     */
    public function deleteById($id);

    /**
     * Delete banners by their associated ids
     * 
     * @param array $ids Array of banner ids
     * @return boolean
     */
    public function deleteByIds(array $ids);
}
