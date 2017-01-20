<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2017/1/5
 * Time: 14:48:33
 */
namespace ApigilityAdmin\Service;

use Zend\ServiceManager\ServiceManager;

class PermissionServiceFactory
{
    public function __invoke(ServiceManager $services)
    {
        return new PermissionService($services);
    }
}