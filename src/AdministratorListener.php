<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/12/6
 * Time: 15:04
 */
namespace ApigilityAdmin;

use ApigilityUser\Service\IdentityService;
use ApigilityUser\Service\UserService;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\EventManager\EventInterface;
use Zend\ServiceManager\ServiceManager;

class AdministratorListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    private $services;

    /**
     * @var \ApigilityUser\Service\IdentityService
     */
    private $identityService;

    public function __construct(ServiceManager $services)
    {
        $this->services = $services;
    }

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(UserService::EVENT_USER_CREATED, [$this, 'createAdministrator'], $priority);
    }

    public function createAdministrator(EventInterface $e)
    {
        $params = $e->getParams();

        // 创建管理员记录
        $this->identityService = $this->services->get('ApigilityUser\Service\IdentityService');
        $identity = $this->identityService->getIdentity($params['user']->getId());
        if ($identity->getType() == 'administrator') {
            $this->getAdministratorService()->createAdministrator((object)[
                'name'=>'管理员'.$params['user']->getId(),
                'user_id'=>$params['user']->getId()
            ]);
        }
    }

    /**
     * @return \ApigilityAdmin\Service\AdministratorService
     */
    private function getAdministratorService()
    {
        return $this->services->get('ApigilityAdmin\Service\AdministratorService');
    }
}