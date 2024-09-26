<?php
// novaina an'io ambany io:
namespace App\Entity;

use App\Repository\SellerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SellerRepository::class)]
class Seller
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(length: 255)]
    private ?string $descriptionSeller = null;

    #[ORM\Column(length: 255)]
    private ?string $buttonSeller = null;

    #[ORM\Column(length: 255)]
    private ?string $illustration = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getDescriptionSeller(): ?string
    {
        return $this->descriptionSeller;
    }

    public function setDescriptionSeller(string $descriptionSeller): static
    {
        $this->descriptionSeller = $descriptionSeller;

        return $this;
    }

    public function getButtonSeller(): ?string
    {
        return $this->buttonSeller;
    }

    public function setButtonSeller(string $buttonSeller): static
    {
        $this->buttonSeller = $buttonSeller;

        return $this;
    }

    public function getIllustration(): ?string
    {
        return $this->illustration;
    }

    public function setIllustration(string $illustration): static
    {
        $this->illustration = $illustration;

        return $this;
    }
}