<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ApiResource(
 *     shortName="productareas",
 *     normalizationContext={"groups"={"readProductArea"}},
 *     denormalizationContext={"groups"={"writeProductArea"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ProductAreaRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class ProductArea
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"readProductArea", "writeProductArea", "readProduct", "writeProduct", "readStore", "writeStore"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"readProductArea", "writeProductArea", "readProduct", "writeProduct", "readStore", "writeStore"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"readProductArea", "writeProductArea", "readProduct", "writeProduct", "readStore", "writeStore"})
     */
    private $description;

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
}
