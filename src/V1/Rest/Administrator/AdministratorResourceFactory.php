<?php
namespace ApigilityAdmin\V1\Rest\Administrator;

class AdministratorResourceFactory
{
    public function __invoke($services)
    {
        return new AdministratorResource($services);
    }
}
