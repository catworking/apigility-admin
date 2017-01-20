<?php
namespace ApigilityAdmin\V1\Rest\Permission;

use ApigilityCatworkFoundation\Base\ApigilityResource;
use Zend\ServiceManager\ServiceManager;
use ZF\ApiProblem\ApiProblem;

class PermissionResource extends ApigilityResource
{
    /**
     * @var \ApigilityAdmin\Service\PermissionService
     */
    protected $permissionService;

    public function __construct(ServiceManager $services)
    {
        parent::__construct($services);
        $this->permissionService = $services->get('ApigilityAdmin\Service\PermissionService');
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
            return new PermissionEntity($this->permissionService->createPermission($data));
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * Patch a resource
     *
     * @param mixed $id
     * @param mixed $data
     * @return PermissionEntity|ApiProblem
     */
    public function patch($id, $data)
    {
        try {
            return new PermissionEntity($this->permissionService->updatePermission($id, $data));
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
            return $this->permissionService->deletePermission($id);
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
            return new PermissionEntity($this->permissionService->getPermission($id));
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
            return new PermissionCollection($this->permissionService->getPermissions($params));
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }
}
