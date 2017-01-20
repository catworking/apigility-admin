<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2017/1/5
 * Time: 14:49:22
 */
namespace ApigilityAdmin\Service;

use ApigilityUser\Service\UserService;
use Zend\ServiceManager\ServiceManager;
use Zend\Hydrator\ClassMethods as ClassMethodsHydrator;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrineToolPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrinePaginatorAdapter;
use ApigilityAdmin\DoctrineEntity;

class RoleService
{
    protected $classMethodsHydrator;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var PermissionService
     */
    protected $permissionService;

    public function __construct(ServiceManager $services)
    {
        $this->classMethodsHydrator = new ClassMethodsHydrator();
        $this->em = $services->get('Doctrine\ORM\EntityManager');
        $this->permissionService = $services->get('ApigilityAdmin\Service\PermissionService');
    }

    /**
     * 创建角色
     *
     * @param $data
     * @param array $permissions
     * @return DoctrineEntity\Role
     * @throws \Exception
     */
    public function createRole($data, $permissions = [])
    {
        $role = new DoctrineEntity\Role();

        if (isset($data->name)) $role->setName($data->name);
        else throw new \Exception('请输入角色名称', 500);

        if (isset($data->description)) $role->setDescription($data->description);

        if (!empty($permissions)) {
            foreach ($permissions as $permission) {
                if ($permission instanceof DoctrineEntity\Permission) {
                    $role->addPermission($permission);
                }
            }
        }

        $this->em->persist($role);
        $this->em->flush();

        return $role;
    }

    /**
     * 获取角色
     *
     * @param $role_id
     * @return DoctrineEntity\Role
     * @throws \Exception
     */
    public function getRole($role_id)
    {
        $role = $this->em->find('ApigilityAdmin\DoctrineEntity\Role', $role_id);
        if (empty($role)) throw new \Exception('角色不存在', 404);
        else return $role;
    }

    /**
     * 获取角色列表
     *
     * @param $params
     * @return DoctrinePaginatorAdapter
     */
    public function getRoles($params)
    {
        $qb = new QueryBuilder($this->em);
        $qb->select('r')->from('ApigilityAdmin\DoctrineEntity\Role', 'r');

        $doctrine_paginator = new DoctrineToolPaginator($qb->getQuery());
        return new DoctrinePaginatorAdapter($doctrine_paginator);
    }

    /**
     * 修改角色
     *
     * @param $role_id
     * @param $data
     * @return DoctrineEntity\Role
     * @throws \Exception
     */
    public function updateRole($role_id, $data)
    {
        $role = $this->getRole($role_id);

        if (isset($data->name)) $role->setName($data->name);
        if (isset($data->description)) $role->setDescription($data->description);

        if (isset($data->permissions)) {
            $role->getPermissions()->clear();
            $ids = explode(',', $data->permissions);
            if (count($ids) > 0) {
                foreach ($ids as $id) {
                    $permission = $this->permissionService->getPermission($id);
                    if ($permission instanceof DoctrineEntity\Permission) $role->addPermission($permission);
                }
            }
        }

        $this->em->flush();

        return $role;
    }

    /**
     * 删除角色
     *
     * @param $role_id
     * @return bool
     * @throws \Exception
     */
    public function deleteRole($role_id)
    {
        $role = $this->getRole($role_id);

        $this->em->remove($role);
        $this->em->flush();

        return true;
    }
}