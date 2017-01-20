<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2017/1/5
 * Time: 14:47:32
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
use ApigilityUser\DoctrineEntity\User;

/**
 * Class Administrator
 * @package ApigilityAdmin\DoctrineEntity
 * @Entity @Table(name="apigilityadmin_administrator")
 */
class Administrator
{
    const STATUS_NORMAL = 1; // 正常
    const STATUS_DISABLE = 2; // 禁用

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * 登录名
     *
     * @Column(type="string", length=32, unique=true, nullable=false)
     */
    protected $name;

    /**
     * ApigilityUser组件的User对象
     *
     * @OneToOne(targetEntity="ApigilityUser\DoctrineEntity\User")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * 管理员角色
     *
     * @ManyToMany(targetEntity="Role", inversedBy="administrators")
     * @JoinTable(name="apigilityadmin_administrators_has_roles")
     */
    protected $roles;

    /**
     * 状态
     *
     * @Column(type="smallint", nullable=false)
     */
    protected $status;

    /**
     * 创建时间
     *
     * @Column(type="datetime", nullable=false)
     */
    protected $create_time;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
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

    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
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

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setCreateTime($create_time)
    {
        $this->create_time = $create_time;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreateTime()
    {
        return $this->create_time;
    }
}