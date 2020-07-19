<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"readProduct"}},
 *     denormalizationContext={"groups"={"writeProduct"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"read", "write", "readProduct", "writeProduct", "readStore", "writeStore", "readPurchase", "writePurchase", "readPurchaseDetail", "writePurchaseDetail"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read", "write", "readProduct", "writeProduct", "readStore", "writeStore"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"readProduct", "writeProduct", "readStore", "writeStore"})
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     * @Groups({"read", "write", "readProduct", "writeProduct", "readStore", "writeStore"})
     */
    private $price;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ProductDetail", cascade={"persist"}, orphanRemoval=true)
     * @ORM\JoinTable(name="product_detail_union",
     *     joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="detail_id", referencedColumnName="id", unique=true)}
     * )
     * @Groups({"readProduct", "writeProduct", "readStore", "writeStore"})
     */
    private $details;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Store", inversedBy="products")
     * @ORM\JoinColumn(name="store_id", referencedColumnName="id")
     * @Groups({"readProduct", "writeProduct"})
     */
    private $store;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Image", cascade={"persist", "remove"})
     * @Groups({"readProduct", "writeProduct", "readStore", "writeStore"})
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProductArea")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"readProduct", "writeProduct", "readStore", "writeStore"})
     */
    private $area;

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
        $this->details = new ArrayCollection();
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection|ProductDetail[]
     */
    public function getDetails(): Collection
    {
        return $this->details;
    }

    public function addDetail(ProductDetail $detail): self
    {
        if (!$this->details->contains($detail)) {
            $this->details[] = $detail;
            $detail->setProduct($this);
        }

        return $this;
    }

    public function removeDetail(ProductDetail $detail): self
    {
        if ($this->details->contains($detail)) {
            $this->details->removeElement($detail);
            // set the owning side to null (unless already changed)
            if ($detail->getProduct() === $this) {
                $detail->setProduct(null);
            }
        }

        return $this;
    }

    public function getStore(): ?Store
    {
        return $this->store;
    }

    public function setStore(?Store $store): self
    {
        $this->store = $store;

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

    public function getArea(): ?ProductArea
    {
        return $this->area;
    }

    public function setArea(?ProductArea $area): self
    {
        $this->area = $area;

        return $this;
    }
}
