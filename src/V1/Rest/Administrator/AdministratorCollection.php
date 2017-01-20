<?php
namespace ApigilityAdmin\V1\Rest\Administrator;

use ApigilityCatworkFoundation\Base\ApigilityObjectStorageAwareCollection;

class AdministratorCollection extends ApigilityObjectStorageAwareCollection
{
    protected $itemType = AdministratorEntity::class;
}
