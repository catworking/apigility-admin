<?php
namespace ApigilityAdmin\V1\Rest\Permission;

class PermissionResourceFactory
{
    public function __invoke($services)
    {
        return new PermissionResource($services);
    }
}
