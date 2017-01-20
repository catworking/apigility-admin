<?php
namespace ApigilityAdmin\V1\Rest\Permission;

use ApigilityCatworkFoundation\Base\ApigilityCollection;

class PermissionCollection extends ApigilityCollection
{
    protected $itemType = PermissionEntity::class;
}
