<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"readPurchase"}},
 *     denormalizationContext={
 *          "groups"={"writePurchase"}
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\PurchaseRepository")
 */
class Purchase
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"read", "write", "readPurchase", "writePurchase"})
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"read", "write", "readPurchase", "writePurchase"})
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="purchases")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"readPurchase", "writePurchase"})
     */
    private $client;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\PurchaseDetail", cascade={"persist"})
     * @ORM\JoinTable(name="purchase_detail_union",
     *      joinColumns={@ORM\JoinColumn(name="purchase_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="detail_id", referencedColumnName="id", unique=true)}
     * )
     * @Groups({"read", "write", "readPurchase", "writePurchase"})
     */
    private $details;

    public function __construct()
    {
        $this->details = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = new \DateTime("now");

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection|PurchaseDetail[]
     */
    public function getDetails(): Collection
    {
        return $this->details;
    }

    public function addDetail(PurchaseDetail $detail): self
    {
        if (!$this->details->contains($detail)) {
            $this->details[] = $detail;
            $detail->setPurchase($this);
        }

        return $this;
    }

    public function removeDetail(PurchaseDetail $detail): self
    {
        if ($this->details->contains($detail)) {
            $this->details->removeElement($detail);
            // set the owning side to null (unless already changed)
            if ($detail->getPurchase() === $this) {
                $detail->setPurchase(null);
            }
        }

        return $this;
    }
}
