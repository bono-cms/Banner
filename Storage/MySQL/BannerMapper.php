<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Banner\Storage\MySQL;

use Cms\Storage\MySQL\AbstractMapper;
use Banner\Storage\BannerMapperInterface;
use Krystal\Db\Sql\RawSqlFragment;

final class BannerMapper extends AbstractMapper implements BannerMapperInterface
{
    /**
     * {@inheritDoc}
     */
    public static function getTableName()
    {
        return self::getWithPrefix('bono_module_banner');
    }

    /**
     * Increments view count by banner ID
     * 
     * @param string $id
     * @return boolean
     */
    public function incrementViewCount($id)
    {
        return $this->incrementColumnByPk($id, 'views');
    }

    /**
     * Increments click count by banner ID
     * 
     * @param string $id
     * @return boolean
     */
    public function incrementClickCount($id)
    {
        return $this->incrementColumnByPk($id, 'clicks');
    }

    /**
     * Fetches banner name by its associated id
     * 
     * @param string $id Banner's id
     * @return string
     */
    public function fetchNameById($id)
    {
        return $this->findColumnByPk($id, 'name');
    }

    /**
     * Updates a banner
     * 
     * @param array $input Raw input data
     * @return boolean
     */
    public function update(array $input)
    {
        return $this->persist($input);
    }

    /**
     * Adds a banner
     * 
     * @param array $input Raw input data
     * @return boolean
     */
    public function insert(array $input)
    {
        // Append date
        $input['datetime'] = new RawSqlFragment('NOW()');

        return $this->persist($this->getWithLang($input));
    }

    /**
     * Fetches all banners filtered by pagination
     * 
     * @param integer $page Current page
     * @param string $itemsPerPage Per page count
     * @param string $categoryId Optional category ID filter
     * @return array
     */
    public function fetchAllByPage($page, $itemsPerPage, $categoryId)
    {
        // Initial select
        $db = $this->db->select('*')
                       ->from(self::getTableName())
                       ->whereEquals('lang_id', $this->getLangId());

        // Optional category ID filter
        if ($categoryId !== null) {
            $db->andWhereEquals('category_id', $categoryId);
        }

        return $db->orderBy('id')
                  ->desc()
                  ->paginate($page, $itemsPerPage)
                  ->queryAll();
    }

    /**
     * Fetches random banner
     * 
     * @param string $categoryId Optional category ID filter
     * @return array
     */
    public function fetchRandom($categoryId)
    {
        $db = $this->db->select('*')
                       ->from(static::getTableName())
                       ->whereEquals('lang_id', $this->getLangId());
                        
        // Optional category ID filter
        if ($categoryId !== null) {
            $db->andWhereEquals('category_id', $categoryId);
        }

        return $db->orderBy()
                  ->rand()
                  ->query();
    }

    /**
     * Fetches banner's data by its associated id
     * 
     * @param string $id Banner id
     * @return array
     */
    public function fetchById($id)
    {
        return $this->findByPk($id);
    }

    /**
     * Deletes a banner by its associated id
     * 
     * @param string $id Banner's id
     * @return boolean
     */
    public function deleteById($id)
    {
        return $this->deleteByPk($id);
    }
}
