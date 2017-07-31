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
     * @return array
     */
    public function fetchAll()
    {
        $columns = array(
            self::getFullColumnName('id'),
            self::getFullColumnName('name')
        );

        return $this->db->select($columns)
                        ->count(BannerMapper::getFullColumnName('id'), 'banners_count')
                        ->from(BannerMapper::getTableName())
                        ->rightJoin(self::getTableName())
                        ->on()
                        ->equals(self::getFullColumnName('id'), new RawSqlFragment(BannerMapper::getFullColumnName('category_id')))
                        ->groupBy(self::getFullColumnName('id'))
                        ->orderBy(self::getFullColumnName('id'))
                        ->desc()
                        ->queryAll();
    }
}
