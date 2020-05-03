<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     shortName="storeareas",
 *     normalizationContext={"groups"={"readStoreArea"}},
 *     denormalizationContext={"groups"={"writeStoreArea"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\StoreAreaRepository")
 */
class StoreArea
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"readStoreArea", "writeStoreArea", "readStore", "writeStore"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"readStoreArea", "writeStoreArea", "readStore", "writeStore"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"readStoreArea", "writeStoreArea", "readStore", "writeStore"})
     */
    private $description;

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
