<?php
namespace ApigilityAdmin\V1\Rest\Role;

use ApigilityCatworkFoundation\Base\ApigilityResource;
use Zend\ServiceManager\ServiceManager;
use ZF\ApiProblem\ApiProblem;

class RoleResource extends ApigilityResource
{
    /**
     * @var \ApigilityAdmin\Service\RoleService
     */
    protected $roleService;

    public function __construct(ServiceManager $services)
    {
        parent::__construct($services);
        $this->roleService = $services->get('ApigilityAdmin\Service\RoleService');
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        try {
            return new RoleEntity($this->roleService->createRole($data));
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * Patch a resource
     *
     * @param mixed $id
     * @param mixed $data
     * @return RoleEntity|ApiProblem
     */
    public function patch($id, $data)
    {
        try {
            return new RoleEntity($this->roleService->updateRole($id, $data));
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        try {
            return $this->roleService->deleteRole($id);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        try {
            return new RoleEntity($this->roleService->getRole($id));
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        try {
            return new RoleCollection($this->roleService->getRoles($params));
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }
}
