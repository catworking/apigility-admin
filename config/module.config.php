<?php
return [
    'service_manager' => [
        'factories' => [
            \ApigilityAdmin\V1\Rest\Administrator\AdministratorResource::class => \ApigilityAdmin\V1\Rest\Administrator\AdministratorResourceFactory::class,
            \ApigilityAdmin\V1\Rest\Role\RoleResource::class => \ApigilityAdmin\V1\Rest\Role\RoleResourceFactory::class,
            \ApigilityAdmin\V1\Rest\Permission\PermissionResource::class => \ApigilityAdmin\V1\Rest\Permission\PermissionResourceFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'apigility-admin.rest.administrator' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/admin/administrator[/:administrator_id]',
                    'defaults' => [
                        'controller' => 'ApigilityAdmin\\V1\\Rest\\Administrator\\Controller',
                    ],
                ],
            ],
            'apigility-admin.rest.role' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/admin/role[/:role_id]',
                    'defaults' => [
                        'controller' => 'ApigilityAdmin\\V1\\Rest\\Role\\Controller',
                    ],
                ],
            ],
            'apigility-admin.rest.permission' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/admin/permission[/:permission_id]',
                    'defaults' => [
                        'controller' => 'ApigilityAdmin\\V1\\Rest\\Permission\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'apigility-admin.rest.administrator',
            1 => 'apigility-admin.rest.role',
            2 => 'apigility-admin.rest.permission',
        ],
    ],
    'zf-rest' => [
        'ApigilityAdmin\\V1\\Rest\\Administrator\\Controller' => [
            'listener' => \ApigilityAdmin\V1\Rest\Administrator\AdministratorResource::class,
            'route_name' => 'apigility-admin.rest.administrator',
            'route_identifier_name' => 'administrator_id',
            'collection_name' => 'administrator',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [
                0 => 'user_id',
                1 => 'status',
                2 => 'name',
            ],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \ApigilityAdmin\V1\Rest\Administrator\AdministratorEntity::class,
            'collection_class' => \ApigilityAdmin\V1\Rest\Administrator\AdministratorCollection::class,
            'service_name' => 'Administrator',
        ],
        'ApigilityAdmin\\V1\\Rest\\Role\\Controller' => [
            'listener' => \ApigilityAdmin\V1\Rest\Role\RoleResource::class,
            'route_name' => 'apigility-admin.rest.role',
            'route_identifier_name' => 'role_id',
            'collection_name' => 'role',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \ApigilityAdmin\V1\Rest\Role\RoleEntity::class,
            'collection_class' => \ApigilityAdmin\V1\Rest\Role\RoleCollection::class,
            'service_name' => 'Role',
        ],
        'ApigilityAdmin\\V1\\Rest\\Permission\\Controller' => [
            'listener' => \ApigilityAdmin\V1\Rest\Permission\PermissionResource::class,
            'route_name' => 'apigility-admin.rest.permission',
            'route_identifier_name' => 'permission_id',
            'collection_name' => 'permission',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [
                0 => 'permission_id',
            ],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \ApigilityAdmin\V1\Rest\Permission\PermissionEntity::class,
            'collection_class' => \ApigilityAdmin\V1\Rest\Permission\PermissionCollection::class,
            'service_name' => 'Permission',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'ApigilityAdmin\\V1\\Rest\\Administrator\\Controller' => 'HalJson',
            'ApigilityAdmin\\V1\\Rest\\Role\\Controller' => 'HalJson',
            'ApigilityAdmin\\V1\\Rest\\Permission\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'ApigilityAdmin\\V1\\Rest\\Administrator\\Controller' => [
                0 => 'application/vnd.apigility-admin.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'ApigilityAdmin\\V1\\Rest\\Role\\Controller' => [
                0 => 'application/vnd.apigility-admin.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'ApigilityAdmin\\V1\\Rest\\Permission\\Controller' => [
                0 => 'application/vnd.apigility-admin.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'ApigilityAdmin\\V1\\Rest\\Administrator\\Controller' => [
                0 => 'application/vnd.apigility-admin.v1+json',
                1 => 'application/json',
            ],
            'ApigilityAdmin\\V1\\Rest\\Role\\Controller' => [
                0 => 'application/vnd.apigility-admin.v1+json',
                1 => 'application/json',
            ],
            'ApigilityAdmin\\V1\\Rest\\Permission\\Controller' => [
                0 => 'application/vnd.apigility-admin.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            \ApigilityAdmin\V1\Rest\Administrator\AdministratorEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'apigility-admin.rest.administrator',
                'route_identifier_name' => 'administrator_id',
                'hydrator' => \Zend\Hydrator\ClassMethods::class,
            ],
            \ApigilityAdmin\V1\Rest\Administrator\AdministratorCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'apigility-admin.rest.administrator',
                'route_identifier_name' => 'administrator_id',
                'is_collection' => true,
            ],
            \ApigilityAdmin\V1\Rest\Role\RoleEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'apigility-admin.rest.role',
                'route_identifier_name' => 'role_id',
                'hydrator' => \Zend\Hydrator\ClassMethods::class,
            ],
            \ApigilityAdmin\V1\Rest\Role\RoleCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'apigility-admin.rest.role',
                'route_identifier_name' => 'role_id',
                'is_collection' => true,
            ],
            \ApigilityAdmin\V1\Rest\Permission\PermissionEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'apigility-admin.rest.permission',
                'route_identifier_name' => 'permission_id',
                'hydrator' => \Zend\Hydrator\ClassMethods::class,
            ],
            \ApigilityAdmin\V1\Rest\Permission\PermissionCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'apigility-admin.rest.permission',
                'route_identifier_name' => 'permission_id',
                'is_collection' => true,
            ],
        ],
    ],
    'zf-content-validation' => [
        'ApigilityAdmin\\V1\\Rest\\Permission\\Controller' => [
            'input_filter' => 'ApigilityAdmin\\V1\\Rest\\Permission\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'ApigilityAdmin\\V1\\Rest\\Permission\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'name',
                'description' => '权限名称',
                'field_type' => 'string',
                'error_message' => '请输入权限名称',
            ],
            1 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'value',
                'description' => '权限值',
                'error_message' => '请输入权限值',
                'field_type' => 'string',
            ],
        ],
    ],
];
