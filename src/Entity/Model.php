<?php

namespace App\Entity;

use App\Repository\ModelRepository;
use App\Traits\DateTrait;
use App\Traits\EnableTrait;
use Doctrine\ORM\Mapping as ORM;
use Src\Traits\SlugTrait;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: ModelRepository::class)]
class Model
{
    use EnableTrait;
    use SlugTrait;
    use DateTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'le slug ne doit pas dépasser {{ limit }} caractères')]
    #[Assert\NotBlank()]
    private ?string $name = null;


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
}
