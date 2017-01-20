<?php
namespace ApigilityAdmin;

use ApigilityAdmin\AdministratorListener;
use Zend\Config\Config;
use Zend\Mvc\MvcEvent;
use ZF\Apigility\Provider\ApigilityProviderInterface;

class Module implements ApigilityProviderInterface
{
    public function getConfig()
    {
        $doctrine_config = new Config(include __DIR__ . '/config/doctrine.config.php');
        $service_config = new Config(include __DIR__ . '/config/service.config.php');
        $manual_config = new Config(include __DIR__ . '/config/manual.config.php');
        $permission_config = new Config(include __DIR__ . '/config/permission.config.php');

        $module_config = new Config(include __DIR__ . '/config/module.config.php');
        $module_config->merge($doctrine_config);
        $module_config->merge($service_config);
        $module_config->merge($manual_config);
        $module_config->merge($permission_config);

        return $module_config;
    }

    public function getAutoloaderConfig()
    {
        return [
            'ZF\Apigility\Autoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src',
                ],
            ],
        ];
    }

    public function onBootstrap(MvcEvent $e)
    {
        $application = $e->getApplication();
        $services = $application->getServiceManager();

        $userEvents = $services->get('ApigilityUser\Service\UserService')->getEventManager();
        $administrator_listener = new AdministratorListener($services);
        $administrator_listener->attach($userEvents);
    }
}
