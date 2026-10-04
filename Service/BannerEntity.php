<?php

/**
 * This file is part of the Bono CMS
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
     * Determines whether the current entity is an image.
     * 
     * @return boolean
     */
    public function isImage()
    {
        return FileManager::hasExtension($this->getFile(), ['jpg', 'jpeg', 'gif', 'png', 'bmp']);
    }

    /**
     * Determines whether the current entity is a flash file.
     * 
     * @return boolean
     */
    public function isFlash()
    {
        return FileManager::hasExtension($this->getFile(), ['swf']);
    }

    /**
     * Determines whether the current file is neither an image nor flash.
     * 
     * @return boolean
     */
    public function isUnknown()
    {
        return !$this->isImage() && !$this->isFlash();
    }
}