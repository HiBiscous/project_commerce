<?php

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait ImageNameTrait
{
    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank()]
    private ?string $imageName = null;

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): static
    {
        $this->imageName = $imageName;

        return $this;
    }
}
