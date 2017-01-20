<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2017/1/5
 * Time: 14:49:00
 */
namespace ApigilityAdmin\Service;

use Zend\ServiceManager\ServiceManager;

class AdministratorServiceFactory
{
    public function __invoke(ServiceManager $services)
    {
        return new AdministratorService($services);
    }
}