<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"readPurchaseDetail"}},
 *     denormalizationContext={"groups"={"readPurchaseDetail"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\PurchaseDetailRepository")
 */
class PurchaseDetail
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"read", "write", "readPurchase", "writePurchase", "readPurchaseDetail", "writePurchaseDetail"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", cascade={"persist"})
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * @Groups({"read", "write", "readPurchase", "writePurchase", "readPurchaseDetail", "writePurchaseDetail"})
     */
    private $product;

    private $purchase;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"read", "write", "readPurchase", "writePurchase", "readPurchaseDetail", "writePurchaseDetail"})
     */
    private $quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     */
    public function setProduct($product): void
    {
        $this->product = $product;
    }

    public function getPurchase(): ?Purchase
    {
        return $this->purchase;
    }

    public function setPurchase(?Purchase $purchase): self
    {
        $this->purchase = $purchase;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }


}
