<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2017/1/5
 * Time: 14:49:33
 */
namespace ApigilityAdmin\Service;

use Zend\ServiceManager\ServiceManager;

class RoleServiceFactory
{
    public function __invoke(ServiceManager $services)
    {
        return new RoleService($services);
    }
}