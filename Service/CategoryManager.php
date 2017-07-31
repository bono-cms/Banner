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

use Cms\Service\AbstractManager;
use Banner\Storage\CategoryMapperInterface;
use Krystal\Stdlib\VirtualEntity;
use Krystal\Stdlib\ArrayUtils;

final class CategoryManager extends AbstractManager implements CategoryManagerInterface
{
    /**
     * Any compliant banner mapper
     * 
     * @var \Banner\Storage\CategoryMapperInterface
     */
    private $categoryMapper;

    /**
     * State initialization
     * 
     * @param \Banner\Storage\CategoryMapperInterface $categoryMapper 
     * @return void
     */
    public function __construct(CategoryMapperInterface $categoryMapper)
    {
        $this->categoryMapper = $categoryMapper;
    }

    /**
     * {@inheritDoc}
     */
    protected function toEntity(array $row)
    {
        $entity = new VirtualEntity();
        $entity->setId($row['id'], VirtualEntity::FILTER_INT)
               ->setName($row['name'], VirtualEntity::FILTER_HTML)
               ->setBannersCount(isset($row['banners_count']) ? $row['banners_count'] : 0, VirtualEntity::FILTER_INT);

        return $entity;
    }

    /**
     * Returns last category ID
     * 
     * @return integer
     */
    public function getLastId()
    {
        return $this->categoryMapper->getLastId();
    }

    /**
     * Updates a category
     * 
     * @param array $input
     * @return boolean
     */
    public function update(array $input)
    {
        return $this->categoryMapper->persist($input);
    }

    /**
     * Adds banner category
     * 
     * @param array $input
     * @return boolean
     */
    public function add(array $input)
    {
        return $this->categoryMapper->persist($input);
    }

    /**
     * Deletes a category by its ID
     * 
     * @param string $id
     * @return boolean
     */
    public function deleteById($id)
    {
        return $this->categoryMapper->deleteByPk($id);
    }

    /**
     * Fetch category entity by its ID
     * 
     * @param string $id Category ID
     * @return \Krystal\Stdlib\VirtualEntity|boolean
     */
    public function fetchById($id)
    {
        return $this->prepareResult($this->categoryMapper->findByPk($id));
    }

    /**
     * Fetch categories list
     * 
     * @return array
     */
    public function fetchList()
    {
        return ArrayUtils::arrayList($this->categoryMapper->fetchAll(), 'id', 'name');
    }

    /**
     * Fetch all categories
     * 
     * @return array
     */
    public function fetchAll()
    {
        return $this->prepareResults($this->categoryMapper->fetchAll());
    }
}
