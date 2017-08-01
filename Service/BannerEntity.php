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

use Krystal\Filesystem\FileManager;
use Krystal\Stdlib\VirtualEntity;

final class BannerEntity extends VirtualEntity
{
    /**
     * Determines whether current entity is image
     * 
     * @return boolean
     */
    public function isImage()
    {
        return FileManager::hasExtension($this->getFile(), array('jpg', 'jped', 'gif', 'png', 'bmp'));
    }

    /**
     * Determines whether current entity is flash file
     * 
     * @return boolean
     */
    public function isFlash()
    {
        return FileManager::hasExtension($this->getFile(), array('swf'));
    }

    /**
     * Whether current file is not image nor flash
     * 
     * @return boolean
     */
    public function isUnknown()
    {
        return !$this->isImage() && !$this->isFlash();
    }
}
