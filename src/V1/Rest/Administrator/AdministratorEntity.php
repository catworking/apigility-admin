<?php
namespace ApigilityAdmin\V1\Rest\Administrator;

use ApigilityAdmin\V1\Rest\Role\RoleEntity;
use ApigilityCatworkFoundation\Base\ApigilityObjectStorageAwareEntity;
use ApigilityUser\DoctrineEntity\User;
use ApigilityUser\V1\Rest\User\UserEntity;
use Doctrine\Common\Collections\ArrayCollection;

class AdministratorEntity extends ApigilityObjectStorageAwareEntity
{
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

    public function getUser()
    {
        if ($this->user instanceof User) return $this->hydrator->extract(new UserEntity($this->user, $this->serviceManager));
        else return $this->user;
    }

    public function setRoles($roles)
    {
        $this->roles = $roles;
        return $this;
    }

    public function getRoles()
    {
        if ($this->roles instanceof ArrayCollection && $this->roles->count() > 0)
            return $this->getJsonValueFromDoctrineCollection($this->roles, RoleEntity::class);
        else
            return [];
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

    public function getCreateTime()
    {
        if ($this->create_time instanceof \DateTime) return $this->create_time->getTimestamp();
        return $this->create_time;
    }
}
