<?php

namespace App\Entity;

use App\Repository\MarqueRepository;
use App\Traits\DateTrait;
use App\Traits\EnableTrait;
use App\Traits\ImageNameTrait;
use App\Traits\SlugTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MarqueRepository::class)]
class Marque
{
    use DateTrait;
    use EnableTrait;
    use SlugTrait;
    use ImageNameTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'le nom ne doit pas dépasser {{ limit }} caractères')]
    #[Assert\NotBlank()]
    private ?string $name = null;


    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }
}
