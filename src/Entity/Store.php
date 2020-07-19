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
 *     normalizationContext={"groups"={"readStore"}},
 *     denormalizationContext={"groups"={"writeStore"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\StoreRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class Store
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"readStore", "writeStore", "readProduct", "writeProduct"})
     * @ApiFilter(SearchFilter::class, properties={"user.username": "exact"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"readStore", "writeStore"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=15)
     * @Groups({"readStore", "writeStore"})
     */
    private $CUIL;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"readStore", "writeStore"})
     */
    private $businessName;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Address", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Groups({"readStore", "writeStore"})
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="store", orphanRemoval=true, fetch="EAGER")
     * @Groups({"readStore", "writeStore"})
     */
    private $products;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Image", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Groups({"readStore", "writeStore"})
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\StoreArea")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"readStore", "writeStore"})
     */
    private $area;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"readStore", "writeStore"})
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
        $this->products = new ArrayCollection();
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

    public function getCUIL(): ?string
    {
        return $this->CUIL;
    }

    public function setCUIL(string $CUIL): self
    {
        $this->CUIL = $CUIL;

        return $this;
    }

    public function getBusinessName(): ?string
    {
        return $this->businessName;
    }

    public function setBusinessName(string $businessName): self
    {
        $this->businessName = $businessName;

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
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setStore($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getStore() === $this) {
                $product->setStore(null);
            }
        }

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getArea(): ?StoreArea
    {
        return $this->area;
    }

    public function setArea(?StoreArea $area): self
    {
        $this->area = $area;

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
            array_push($roles, 'ROLE_BUSINESS');
            $user->setRoles($roles);
        }
        else{
            if (count($user->getRoles()) == 0) {
                array_push($roles, 'ROLE_BUSINESS');
                $user->setRoles($roles);
            }
        }

        $this->user = $user;

        return $this;
    }
}
