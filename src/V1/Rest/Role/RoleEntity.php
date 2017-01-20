<?php
namespace ApigilityAdmin\V1\Rest\Role;

use ApigilityAdmin\V1\Rest\Permission\PermissionEntity;
use ApigilityCatworkFoundation\Base\ApigilityEntity;
use Doctrine\Common\Collections\ArrayCollection;

class RoleEntity extends ApigilityEntity
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * 角色名
     *
     * @Column(type="string", length=32, unique=true, nullable=false)
     */
    protected $name;

    /**
     * 角色描述
     *
     * @Column(type="string", length=800, nullable=true)
     */
    protected $description;

    /**
     * 拥有此角色的管理员
     *
     * @ManyToMany(targetEntity="Administrator", mappedBy="roles")
     */
    protected $administrators;

    /**
     * 角色被赋予的权限
     *
     * @ManyToMany(targetEntity="Permission", inversedBy="roles")
     * @JoinTable(name="apigilityadmin_roles_has_permissions")
     */
    protected $permissions;

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setAdministrators($administrators)
    {
        $this->administrators = $administrators;
        return $this;
    }

    public function getAdministrators()
    {
        return $this->administrators->count();
    }

    public function setPermissions($permissions)
    {
        $this->permissions = $permissions;
        return $this;
    }

    public function getPermissions()
    {
        if ($this->permissions instanceof ArrayCollection && $this->permissions->count() > 0) {
            return $this->getJsonValueFromDoctrineCollection($this->permissions, PermissionEntity::class);
        } else {
            return [];
        }
    }
}
