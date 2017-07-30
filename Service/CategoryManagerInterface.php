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

interface CategoryManagerInterface
{
    /**
     * Returns last category ID
     * 
     * @return integer
     */
    public function getLastId();
    
    /**
     * Updates a category
     * 
     * @param array $input
     * @return boolean
     */
    public function update(array $input);

    /**
     * Adds banner category
     * 
     * @param array $input
     * @return boolean
     */
    public function add(array $input);

    /**
     * Deletes a category by its ID
     * 
     * @param string $id
     * @return boolean
     */
    public function deleteById($id);

    /**
     * Fetch category entity by its ID
     * 
     * @param string $id Category ID
     * @return \Krystal\Stdlib\VirtualEntity|boolean
     */
    public function fetchById($id);

    /**
     * Fetch categories list
     * 
     * @return array
     */
    public function fetchList();

    /**
     * Fetch all categories
     * 
     * @return array
     */
    public function fetchAll();
}
