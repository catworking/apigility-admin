<?php
namespace ApigilityAdmin\V1\Rest\Permission;

use ApigilityAdmin\DoctrineEntity\Permission;
use ApigilityCatworkFoundation\Base\ApigilityEntity;

class PermissionEntity extends ApigilityEntity
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * 权限名称
     *
     * @Column(type="string", length=32, unique=true, nullable=false)
     */
    protected $name;

    /**
     * 权限值
     *
     * @Column(type="string", length=32, unique=true, nullable=false)
     */
    protected $value;

    /**
     * 权限描述
     *
     * @Column(type="string", length=800, nullable=true)
     */
    protected $description;

    /**
     * 拥有此角色的管理员
     *
     * @ManyToMany(targetEntity="Role", mappedBy="permissions")
     */
    protected $roles;

    /**
     * @OneToMany(targetEntity="Permission", mappedBy="parent")
     */
    protected $children;

    /**
     * @ManyToOne(targetEntity="Permission", inversedBy="children")
     * @JoinColumn(name="permission_id", referencedColumnName="id")
     */
    protected $parent;

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

    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    public function getValue()
    {
        return $this->value;
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

    public function setRoles($roles)
    {
        $this->roles = $roles;
        return $this;
    }

    public function getRoles()
    {
        return $this->roles->count();
    }

    public function setParent($parent)
    {
        $this->parent = $parent;
        return $this;
    }

    public function getParent()
    {
        if ($this->parent instanceof Permission) return $this->hydrator->extract(new PermissionEntity($this->parent));
        else return $this->parent;
    }
}
