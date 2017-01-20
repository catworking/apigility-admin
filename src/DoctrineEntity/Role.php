<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2017/1/5
 * Time: 14:47:45
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
 * Class Role
 * @package ApigilityAdmin\DoctrineEntity
 * @Entity @Table(name="apigilityadmin_role")
 */
class Role
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

    public function __construct()
    {
        $this->administrators = new ArrayCollection();
        $this->permissions = new ArrayCollection();
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
        return $this->administrators;
    }

    public function addAdministrator($administrator)
    {
        $this->administrators[] = $administrator;
        return $this;
    }

    public function setPermissions($permissions)
    {
        $this->permissions = $permissions;
        return $this;
    }

    public function getPermissions()
    {
        return $this->permissions;
    }

    public function addPermission(Permission $permission)
    {
        $this->permissions[] = $permission;
        return $this;
    }
}