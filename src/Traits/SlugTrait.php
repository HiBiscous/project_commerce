<?php

namespace Src\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait SlugTrait
{
    #[ORM\Column(length: 255)]
    #[Assert\Length(max: 255, maxMessage: 'le slug ne doit pas dépasser {{ limit }} caractères')]
    #[Assert\NotBlank()]
    private ?string $slug = null;

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }
}
