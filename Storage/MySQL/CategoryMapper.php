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
use Banner\Storage\CategoryMapperInterface;
use Krystal\Db\Sql\RawSqlFragment;

final class CategoryMapper extends AbstractMapper implements CategoryMapperInterface
{
    /**
     * {@inheritDoc}
     */
    public static function getTableName()
    {
        return self::getWithPrefix('bono_module_banner_categories');
    }

    /**
     * Fetch all categories
     * 
     * @param boolean $withCount Whether fetch virtual count field as well
     * @return array
     */
    public function fetchAll($withCount)
    {
        // Columns to be selected
        $columns = array(
            self::column('id'),
            self::column('name')
        );

        if ($withCount == true) {
            $db = $this->db->select($columns)
                        ->count(BannerMapper::column('id'), 'banners_count')
                        ->from(BannerMapper::getTableName())
                        ->rightJoin(self::getTableName(), array(
                            self::column('id') => BannerMapper::getRawColumn('category_id')
                        ))
                        ->groupBy(self::column('id'));
        } else {
            $db = $this->db->select($columns)
                           ->from(self::getTableName());
        }

        return $db->orderBy(self::column('id'))
                  ->desc()
                  ->queryAll();
    }
}
