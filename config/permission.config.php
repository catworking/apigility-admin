<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2017/1/7
 * Time: 11:57:35
 */
return [
    'apigility-admin' => [
        'permission' => [
            [
                'name' => '管理员模块',
                'value' => 'apigility-admin',
                'children' => [
                    [
                        'name' => '权限管理',
                        'value' => 'apigility-admin.permission',
                        'children' => [
                            [
                                'name' => '创建权限',
                                'value' => 'apigility-admin.permission.post',
                            ],
                            [
                                'name' => '修改权限',
                                'value' => 'apigility-admin.permission.patch',
                            ],
                            [
                                'name' => '读取权限',
                                'value' => 'apigility-admin.permission.get',
                            ],
                            [
                                'name' => '查找权限',
                                'value' => 'apigility-admin.permission.get-list',
                            ],
                            [
                                'name' => '删除权限',
                                'value' => 'apigility-admin.permission.delete',
                            ]
                        ]
                    ],
                    [
                        'name' => '角色管理',
                        'value' => 'apigility-admin.role',
                        'children' => [
                            [
                                'name' => '创建角色',
                                'value' => 'apigility-admin.role.post',
                            ],
                            [
                                'name' => '修改角色',
                                'value' => 'apigility-admin.role.patch',
                            ],
                            [
                                'name' => '读取角色',
                                'value' => 'apigility-admin.role.get',
                            ],
                            [
                                'name' => '查找角色',
                                'value' => 'apigility-admin.role.get-list',
                            ],
                            [
                                'name' => '删除角色',
                                'value' => 'apigility-admin.role.delete',
                            ]
                        ]
                    ],
                    [
                        'name' => '管理员管理',
                        'value' => 'apigility-admin.administrator',
                        'children' => [
                            [
                                'name' => '创建管理员',
                                'value' => 'apigility-admin.administrator.create',
                            ],
                            [
                                'name' => '修改管理员',
                                'value' => 'apigility-admin.administrator.update',
                            ],
                            [
                                'name' => '读取管理员',
                                'value' => 'apigility-admin.administrator.read',
                            ],
                            [
                                'name' => '查找管理员',
                                'value' => 'apigility-admin.administrator.get-list',
                            ],
                            [
                                'name' => '删除管理员',
                                'value' => 'apigility-admin.administrator.delete',
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
];