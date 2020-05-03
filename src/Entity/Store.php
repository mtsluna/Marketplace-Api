<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"readStore"}},
 *     denormalizationContext={"groups"={"writeStore"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\StoreRepository")
 */
class Store
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"readStore", "writeStore", "readProduct", "writeProduct"})
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
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="store", orphanRemoval=true)
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
}
