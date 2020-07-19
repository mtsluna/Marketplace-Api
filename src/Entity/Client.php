<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}}
 * )
 * @ApiFilter(SearchFilter::class, properties={"user.username": "exact"})
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class Client
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"read", "write", "readPurchase", "writePurchase"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read", "write"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read", "write"})
     */
    private $surname;

    /**
     * @ORM\Column(type="bigint")
     * @Groups({"read", "write"})
     */
    private $dni;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Address", cascade={"persist"})
     * @ORM\JoinColumn(name="address_id", referencedColumnName="id")
     * @Groups({"read", "write"})
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Purchase", mappedBy="client", orphanRemoval=true)
     * @Groups({"read", "write"})
     */
    private $purchases;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", cascade={"persist", "remove"})
     * @ORM\JoinColumn()
     * @Groups({"read", "write"})
     */
    private $user;

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

    public function __construct()
    {
        $this->purchases = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getDni(): ?string
    {
        return $this->dni;
    }

    public function setDni(string $dni): self
    {
        $this->dni = $dni;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection|Purchase[]
     */
    public function getPurchases(): Collection
    {
        return $this->purchases;
    }

    public function addPurchase(Purchase $purchase): self
    {
        if (!$this->purchases->contains($purchase)) {
            $this->purchases[] = $purchase;
            $purchase->setClient($this);
        }

        return $this;
    }

    public function removePurchase(Purchase $purchase): self
    {
        if ($this->purchases->contains($purchase)) {
            $this->purchases->removeElement($purchase);
            // set the owning side to null (unless already changed)
            if ($purchase->getClient() === $this) {
                $purchase->setClient(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {

        $roles = $user->getRoles();
        if($roles == null) {
            $roles = [];
            array_push($roles, 'ROLE_CLIENT');
            $user->setRoles($roles);
        }
        else{
            if (count($user->getRoles()) == 0) {
                array_push($roles, 'ROLE_CLIENT');
                $user->setRoles($roles);
            }
        }

        $this->user = $user;

        return $this;
    }

}
