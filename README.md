Banner module
=========

The Banner module is designed for managing Flash banners on your site (typically with a `.swf` extension). It provides a single globally available service, `$banner`, which includes the following methods:

# Service Methods

## Getting random banner
The signature is the following:

 `\Banner\Service\SiteService::getRandom()`

Returns a random banner entity object.
Basic example:

    <?php
    
    $entity= $entity->getRandom();
    
    ?>
    
    <?php if ($entity): ?>
    <div>
        <embed src="<?= $entity->getUrlPath(); ?>" />
    </div>
    <?php endif; ?>

## Get banner by id
The signature is the following:

 `\Banner\Service\SiteService::getById($id)`

Retrieves a banner entity object by its associated ID.

Basic example:

    <div>
        <embed src="<?= $banner->getById(1)->getUrlPath(); ?>" />
    </div>

*Assuming a banner with `id = 1` exists*

# Entity Object Methods
A banner entity object provides the following methods:

    $entity->getId(); // Returns the unique ID of the banner.
    $entity->getName(); // Retrieves the name of the banner.
    $entity->getLink(); // Returns the URL associated with the banner (if specified)
    $entity->getUrlPath(); // Provides the full URL where the banner is located