<?php


namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"readUser"}},
 *     denormalizationContext={"groups"={"writeUser"}}
 * )
 * @ORM\Table(name="users")
 * @ORM\Entity
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class User implements UserInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"read", "write", "readUser", "writeUser", "readStore", "writeStore"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     * @Groups({"read", "write", "readUser", "writeUser", "readStore", "writeStore"})
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=500)
     * @Groups({"write", "writeUser", "writeStore"})
     */
    private $password;

    /**
     * @var roles
     *
     * @ORM\Column(type="array")
     * @Groups({"read", "write", "readUser", "writeUser", "readStore", "writeStore"})
     */
    private $roles;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**

     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)

     */
    private $deletedAt;

    /**
     * @return mixed
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * @param mixed $deletedAt
     */
    public function setDeletedAt($deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }

    public function __construct($username)
    {
        $this->isActive = true;
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function getSalt()
    {
        return null;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = password_hash($password, 1);
    }

    public function setRoles($roles){
        if(!empty($roles)){
            $this->roles = $roles;
            return $this;
        }
        return $this;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function eraseCredentials()
    {
    }

    public function getUsername()
    {
        return $this->username;
    }
}