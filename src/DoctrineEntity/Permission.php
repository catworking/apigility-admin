<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2017/1/5
 * Time: 14:47:56
 */
namespace ApigilityAdmin\DoctrineEntity;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Permission
 * @package ApigilityAdmin\DoctrineEntity
 * @Entity @Table(name="apigilityadmin_permission")
 */
class Permission
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * 权限名称
     *
     * @Column(type="string", length=255, unique=true, nullable=false)
     */
    protected $name;

    /**
     * 权限值
     *
     * @Column(type="string", length=255, unique=true, nullable=false)
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

    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->children = new ArrayCollection();
    }

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
        return $this->roles;
    }

    public function addRole(Role $role)
    {
        $this->roles[] = $role;
        return $this;
    }

    public function setParent(Permission $parent)
    {
        $this->parent = $parent;
        return $this;
    }

    public function getParent()
    {
        return $this->parent;
    }
}