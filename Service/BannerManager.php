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
use Banner\Storage\BannerMapperInterface;
use Krystal\Http\FileTransfer\DirectoryBagInterface;
use Krystal\Http\FileTransfer\UrlPathGeneratorInterface;

final class BannerManager extends AbstractManager implements BannerManagerInterface
{
    /**
     * Any compliant banner mapper
     * 
     * @var \Banner\Storage\BannerMapperInterface
     */
    private $banerMapper;

    /**
     * Directory bag
     * 
     * @var \Krystal\Http\FileTransfer\DirectoryBagInterface
     */
    private $dirBag;

    /**
     * Generator for banner URL paths
     * 
     * @var \Krystal\Http\FileTransfer\UrlPathGeneratorInterface
     */
    private $urlPathGenerator;

    const EXPIRATION_TYPE_NEVER = 0;
    const EXPIRATION_TYPE_CLICKS = 1;
    const EXPIRATION_TYPE_VIEWS = 2;
    const EXPIRATION_TYPE_DATETIME = 3;

    /**
     * State initialization
     * 
     * @param \Banner\Storage\BannerMapperInterface $banerMapper
     * @param \Krystal\Http\FileTransfer\DirectoryBagInterface $dirBag
     * @param \Krystal\Http\FileTransfer\UrlPathGeneratorInterface $urlPathGenerator
     * @return void
     */
    public function __construct(BannerMapperInterface $bannerMapper, DirectoryBagInterface $dirBag, UrlPathGeneratorInterface $urlPathGenerator)
    {
        $this->bannerMapper = $bannerMapper;
        $this->dirBag = $dirBag;
        $this->urlPathGenerator = $urlPathGenerator;
    }

    /**
     * {@inheritDoc}
     */
    protected function toEntity(array $banner)
    {
        $entity = new BannerEntity();
        $entity->setId($banner['id'], BannerEntity::FILTER_INT)
            ->setName($banner['name'], BannerEntity::FILTER_HTML)
            ->setLink($banner['link'], BannerEntity::FILTER_HTML)
            ->setFile($banner['file'], BannerEntity::FILTER_HTML)
            ->setCategoryId($banner['category_id'], BannerEntity::FILTER_INT)
            ->setViewCount($banner['views'], BannerEntity::FILTER_INT)
            ->setMaxViewCount($banner['max_views'], BannerEntity::FILTER_INT)
            ->setClickCount($banner['clicks'], BannerEntity::FILTER_INT)
            ->setMaxClickCount($banner['max_clicks'], BannerEntity::FILTER_INT)
            ->setDatetime($banner['datetime'])
            ->setMaxDatetime($banner['max_datetime'])
            ->setExpirationType($banner['expiration_type'], BannerEntity::FILTER_INT)
            ->setExpirationTypeText($this->getExpirationTypes($entity->getExpirationType()))
            ->setUrlPath($this->urlPathGenerator->getPath($entity->getId(), $entity->getFile()))
            ->setTargetUrl(sprintf('/module/banner/target/?%s', http_build_query(array('id' => $entity->getId(), 'url' => $entity->getLink()))))
            ->setExpired(!$this->isNonExpired($banner));

        return $entity;
    }

    /**
     * Process and keep only valid banners
     * 
     * @param array $banners
     * @return array
     */
    private function getActiveIds()
    {
        static $ids = null;

        if ($ids === null) {
            $banners = $this->bannerMapper->fetchAllByPage(null, null, null);
            $ids = $this->processBanners($banners);
        }

        return $ids;
    }

    /**
     * Validates whether banner is not expired
     * 
     * @param array $banner Banner data
     * @return boolean
     */
    private function isNonExpired(array $banner)
    {
        $type = (int) $banner['expiration_type'];

        static $time = null;

        if ($time == null) {
            $time = $this->bannerMapper->getCurrentTime();
        }

        // Expiration conditions
        $never = $type == self::EXPIRATION_TYPE_NEVER;
        $byClicks = $type == self::EXPIRATION_TYPE_CLICKS && $banner['max_clicks'] > $banner['clicks'];
        $byViews = $type == self::EXPIRATION_TYPE_VIEWS && $banner['max_views'] > $banner['views'];
        $byDatetime = $type == self::EXPIRATION_TYPE_DATETIME && strtotime($banner['max_datetime']) - strtotime($time) > 0;

        return $never || $byClicks || $byViews || $byDatetime;
    }

    /**
     * Process and keep only valid banners
     * 
     * @param array $banners
     * @return array
     */
    private function processBanners(array $banners)
    {
        $output = array();

        foreach ($banners as $banner) {
            if ($this->isNonExpired($banner)) {
                $output[] = $banner['id'];
            }
        }

        return $output;
    }

    /**
     * Returns expiration types
     * 
     * @param integer $filter Optional filtering key
     * @return array
     */
    public function getExpirationTypes($filter = null)
    {
        $types = array(
            self::EXPIRATION_TYPE_NEVER => 'Never',
            self::EXPIRATION_TYPE_CLICKS => 'By clicks',
            self::EXPIRATION_TYPE_VIEWS => 'By views',
            self::EXPIRATION_TYPE_DATETIME => 'By expiration time'
        );

        if ($filter !== null) {
            return $types[$filter];
        }

        return $types;
    }
    
    /**
     * Increments view count by banner ID
     * 
     * @param string $id
     * @return boolean
     */
    public function incrementViewCount($id)
    {
        return $this->bannerMapper->incrementViewCount($id);
    }

    /**
     * Increments click count by banner ID
     * 
     * @param string $id
     * @return boolean
     */
    public function incrementClickCount($id)
    {
        return $this->bannerMapper->incrementClickCount($id);
    }

    /**
     * Returns prepared paginator's instance
     * 
     * @return \Krystal\Paginate\Paginator
     */
    public function getPaginator()
    {
        return $this->bannerMapper->getPaginator();
    }

    /**
     * Returns last banner's id
     * 
     * @return integer
     */
    public function getLastId()
    {
        return $this->bannerMapper->getLastId();
    }

    /**
     * Fetches all banner entities filtered by pagination
     * 
     * @param string $page Current page
     * @param string $itemsPerPage Per page count
     * @param string $categoryId Optional category ID filter
     * @return array An array of banner entities
     */
    public function fetchAllByPage($page, $itemsPerPage, $categoryId = null)
    {
        return $this->prepareResults($this->bannerMapper->fetchAllByPage($page, $itemsPerPage, $categoryId));
    }

    /**
     * Fetches random banner's entity
     * 
     * @param string $categoryId Optional category ID filter
     * @return \Krystal\Stdlib\VirtualEntity
     */
    public function fetchRandom($categoryId = null)
    {
        return $this->prepareResult($this->bannerMapper->fetchRandom($categoryId, $this->getActiveIds()));
    }

    /**
     * Fetches banner's entity by its associated id
     * 
     * @param string $id Banner id
     * @return boolean|\Krystal\Stdlib\VirtualEntity
     */
    public function fetchById($id)
    {
        return $this->prepareResult($this->bannerMapper->fetchById($id));
    }

    /**
     * Adds a banner
     * 
     * @param array $input Raw input data
     * @return boolean
     */
    public function add(array $form)
    {
        if (!empty($form['files']['banner'])) {
            $data =& $form['data']['banner'];
            // In order to get last id, a record needs to be inserted first
            $this->bannerMapper->insert($data);

            // $this->getLastId() works now
            $this->dirBag->upload($this->getLastId(), $form['files']);

            return true;
        } else {
            // No file
            return false;
        }
    }

    /**
     * Updates a banner
     * 
     * @param array $input Raw input data
     * @return boolean
     */
    public function update(array $input)
    {
        $data =& $input['data']['banner'];

        // If we have a new banner
        if (!empty($input['files']['banner'])) {
            $file = $input['files']['banner'];
            // Then we need to remove a previos one
            $this->dirBag->remove($data['id'], $data['file']);

            // And finally upload a new one
            $this->dirBag->upload($data['id'], $input['files']);

            // Save new name now
            $data['file'] = $file->getUniqueName();
        }

        return $this->bannerMapper->update($data);
    }

    /**
     * Deletes a banner by its associated id
     * 
     * @param string $id Banner id
     * @return boolean
     */
    public function deleteById($id)
    {
        return $this->dirBag->remove($id) && $this->bannerMapper->deleteById($id);
    }

    /**
     * Delete banners by their associated ids
     * 
     * @param array $ids An array of banner ids
     * @return boolean
     */
    public function deleteByIds(array $ids)
    {
        foreach ($ids as $id) {
            if (!$this->deleteById($id)) {
                return false;
            }
        }

        return true;
    }
}
