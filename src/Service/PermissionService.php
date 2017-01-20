<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2017/1/5
 * Time: 14:48:17
 */
namespace ApigilityAdmin\Service;

use ApigilityUser\Service\UserService;
use Zend\ServiceManager\ServiceManager;
use Zend\Hydrator\ClassMethods as ClassMethodsHydrator;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrineToolPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrinePaginatorAdapter;
use ApigilityAdmin\DoctrineEntity;

class PermissionService
{
    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    protected $classMethodsHydrator;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    public function __construct(ServiceManager $services)
    {
        $this->serviceManager = $services;
        $this->classMethodsHydrator = new ClassMethodsHydrator();
        $this->em = $services->get('Doctrine\ORM\EntityManager');
    }

    /**
     * 创建权限
     *
     * @param $data
     * @return DoctrineEntity\Permission
     * @throws \Exception
     */
    public function createPermission($data)
    {
        $permission = new DoctrineEntity\Permission();

        if (isset($data->name)) $permission->setName($data->name);
        else throw new \Exception('请输入权限名称', 500);

        if (isset($data->value)) $permission->setValue($data->value);
        else throw new \Exception('请输入权限值', 500);

        if (isset($data->description)) $permission->setDescription($data->description);

        if (isset($data->permission_id)) $permission->setParent($this->getPermission($data->permission_id));

        $this->em->persist($permission);
        $this->em->flush();

        return $permission;
    }

    /**
     * 获取权限
     *
     * @param $permission_id
     * @return DoctrineEntity\Permission
     * @throws \Exception
     */
    public function getPermission($permission_id)
    {
        $permission = $this->em->find('ApigilityAdmin\DoctrineEntity\Permission', $permission_id);
        if (empty($permission)) throw new \Exception('权限不存在', 404);
        else return $permission;
    }

    /**
     * 获取权限列表
     *
     * @param $params
     * @return DoctrinePaginatorAdapter
     */
    public function getPermissions($params)
    {
        $qb = new QueryBuilder($this->em);
        $qb->select('p')->from('ApigilityAdmin\DoctrineEntity\Permission', 'p');

        $where = '';

        if (isset($params->permission_id)) {
            $qb->innerJoin('p.parent', 'pp');
            if (!empty($where)) $where .= ' AND ';
            $where .= 'pp.id = :permission_id';
        }

        if (!empty($where)) {
            $qb->where($where);

            if (isset($params->permission_id)) $qb->setParameter('permission_id', $params->permission_id);
        }

        $doctrine_paginator = new DoctrineToolPaginator($qb->getQuery());
        return new DoctrinePaginatorAdapter($doctrine_paginator);
    }

    /**
     * 修改权限
     *
     * @param $permission_id
     * @param $data
     * @return DoctrineEntity\Permission
     * @throws \Exception
     */
    public function updatePermission($permission_id, $data)
    {
        $permission = $this->getPermission($permission_id);

        if (isset($data->name)) $permission->setName($data->name);
        if (isset($data->value)) $permission->setValue($data->value);
        if (isset($data->description)) $permission->setDescription($data->description);
        if (isset($data->permission_id)) {
            $parent = $this->getPermission($data->permission_id);
            $permission->setParent($parent);
        }

        $this->em->flush();

        return $permission;
    }

    /**
     * 删除权限
     *
     * @param $permission_id
     * @return bool
     * @throws \Exception
     */
    public function deletePermission($permission_id)
    {
        $permission = $this->getPermission($permission_id);

        $this->em->remove($permission);
        $this->em->flush();

        return true;
    }

    /**
     * 把所有模块中的权限配置持久化到数据库中
     */
    public function persistPermissionData()
    {
        $config = $this->serviceManager->get('config');

        $count = 0;
        foreach ($config['apigility-admin']['permission'] as $permission_data) {
            $count += $this->persistPermissionItem($permission_data);
        }

        return $count;
    }

    private function persistPermissionItem($permission_data, $parent_permission = null)
    {
        static $count = 0;
        $count++;

        $prepare_data = [];
        if (!isset($permission_data['name']) || !isset($permission_data['value'])) throw new \Exception('缺少权限名称或权限值', 500);

        $prepare_data['name'] = $permission_data['name'];
        $prepare_data['value'] = $permission_data['value'];
        if (isset($permission_data['description'])) $prepare_data['description'] = $permission_data['description'];
        if ($parent_permission instanceof DoctrineEntity\Permission) $prepare_data['permission_id'] = $parent_permission->getId();

        $permission = $this->createPermission((object)$prepare_data);

        if (isset($permission_data['children']) && is_array($permission_data['children'])) {
            foreach ($permission_data['children'] as $permission_item_data) {
                $this->persistPermissionItem($permission_item_data, $permission);
            }
        }

        return $count;
    }
}