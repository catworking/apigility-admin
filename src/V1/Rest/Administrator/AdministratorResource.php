<?php
namespace ApigilityAdmin\V1\Rest\Administrator;

use ApigilityCatworkFoundation\Base\ApigilityResource;
use Zend\ServiceManager\ServiceManager;
use ZF\ApiProblem\ApiProblem;

class AdministratorResource extends ApigilityResource
{
    /**
     * @var \ApigilityAdmin\Service\AdministratorService
     */
    protected $administratorService;

    public function __construct(ServiceManager $services)
    {
        parent::__construct($services);
        $this->administratorService = $services->get('ApigilityAdmin\Service\AdministratorService');
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
            return new AdministratorEntity($this->administratorService->createAdministrator($data), $this->serviceManager);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * Patch a resource
     *
     * @param mixed $id
     * @param mixed $data
     * @return AdministratorEntity|ApiProblem
     */
    public function patch($id, $data)
    {
        try {
            return new AdministratorEntity($this->administratorService->updateAdministrator($id, $data), $this->serviceManager);
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
            return $this->administratorService->deleteAdministrator($id);
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
            return new AdministratorEntity($this->administratorService->getAdministrator($id), $this->serviceManager);
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
            return new AdministratorCollection($this->administratorService->getAdministrators($params), $this->serviceManager);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }
}
