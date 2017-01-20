<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2017/1/5
 * Time: 14:48:48
 */

namespace ApigilityAdmin\Service;

use ApigilityUser\DoctrineEntity\User;
use ApigilityUser\Service\UserService;
use Zend\ServiceManager\ServiceManager;
use Zend\Hydrator\ClassMethods as ClassMethodsHydrator;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrineToolPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrinePaginatorAdapter;
use ApigilityAdmin\DoctrineEntity;

class AdministratorService
{
    protected $classMethodsHydrator;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var RoleService
     */
    protected $roleService;

    /**
     * @var UserService
     */
    protected $userService;

    public function __construct(ServiceManager $services)
    {
        $this->classMethodsHydrator = new ClassMethodsHydrator();
        $this->em = $services->get('Doctrine\ORM\EntityManager');
        $this->roleService = $services->get('ApigilityAdmin\Service\RoleService');
        $this->userService = $services->get('ApigilityUser\Service\UserService');
    }

    /**
     * 创建管理员
     *
     * @param $data
     * @param array $roles
     * @return DoctrineEntity\Administrator
     * @throws \Exception
     */
    public function createAdministrator($data, $roles = [])
    {
        $administrator = new DoctrineEntity\Administrator();

        if (isset($data->name)) $administrator->setName($data->name);
        else throw new \Exception('请输入管理员名称', 500);

        if (isset($data->user_id)) $administrator->setUser($this->userService->getUser($data->user_id));
        else throw new \Exception('没有指定用户', 500);

        $administrator->setStatus(DoctrineEntity\Administrator::STATUS_NORMAL);
        $administrator->setCreateTime(new \DateTime());

        if (!empty($roles)) {
            foreach ($roles as $role) {
                if ($role instanceof DoctrineEntity\Role) {
                    $administrator->addRole($role);
                }
            }
        }

        $this->em->persist($administrator);
        $this->em->flush();

        return $administrator;
    }

    /**
     * 获取管理员
     *
     * @param $administrator_id
     * @return DoctrineEntity\Administrator
     * @throws \Exception
     */
    public function getAdministrator($administrator_id)
    {
        $administrator = $this->em->find('ApigilityAdmin\DoctrineEntity\Administrator', $administrator_id);
        if (empty($administrator)) throw new \Exception('管理员不存在', 404);
        else return $administrator;
    }

    /**
     * 获取管理员列表
     *
     * @param $params
     * @return DoctrinePaginatorAdapter
     */
    public function getAdministrators($params)
    {
        $qb = new QueryBuilder($this->em);
        $qb->select('a')->from('ApigilityAdmin\DoctrineEntity\Administrator', 'a');

        $where = '';

        if (isset($params->name)) {
            if (!empty($where)) $where .= ' AND ';
            $where .= 'a.name = :name';
        }

        if (isset($params->status)) {
            if (!empty($where)) $where .= ' AND ';
            $where .= 'a.status = :status';
        }

        if (isset($params->user_id)) {
            $qb->innerJoin('a.user', 'u');
            if (!empty($where)) $where .= ' AND ';
            $where .= 'u.id = :user_id';
        }

        if (!empty($where)) {
            $qb->where($where);

            if (isset($params->name)) $qb->setParameter('name', $params->name);
            if (isset($params->status)) $qb->setParameter('status', $params->status);
            if (isset($params->user_id)) $qb->setParameter('user_id', $params->user_id);
        }

        $doctrine_paginator = new DoctrineToolPaginator($qb->getQuery());
        return new DoctrinePaginatorAdapter($doctrine_paginator);
    }

    /**
     * @param $user_id
     * @return DoctrineEntity\Administrator
     * @throws \Exception
     */
    public function getAdministratorByUserId($user_id)
    {
        $administrators = $this->getAdministrators((object)['user_id'=>$user_id]);
        if ($administrators->count()) {
            return $administrators->getItems(0,1)[0];
        } else {
            throw new \Exception('管理员不存在', 404);
        }
    }

    /**
     * 修改管理员
     *
     * @param $administrator_id
     * @param $data
     * @return DoctrineEntity\Administrator
     * @throws \Exception
     */
    public function updateAdministrator($administrator_id, $data)
    {
        $administrator = $this->getAdministrator($administrator_id);

        if (isset($data->name)) $administrator->setName($data->name);
        if (isset($data->status)) $administrator->setStatus($data->status);

        if (isset($data->roles)) {
            $administrator->getRoles()->clear();
            $ids = explode(',', $data->roles);
            if (count($ids) > 0) {
                foreach ($ids as $id) {
                    $role = $this->roleService->getRole($id);
                    if ($role instanceof DoctrineEntity\Role) $administrator->addRole($role);
                }
            }
        }

        $this->em->flush();

        return $administrator;
    }

    /**
     * 删除管理员
     *
     * @param $administrator_id
     * @return bool
     * @throws \Exception
     */
    public function deleteAdministrator($administrator_id)
    {
        $administrator = $this->getAdministrator($administrator_id);

        $this->em->remove($administrator);
        $this->em->flush();

        return true;
    }
}