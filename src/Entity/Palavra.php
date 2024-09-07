<?php

namespace App\Entity;

use App\Entity\Contexto;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Palavra
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $palavra;

    #[ORM\ManyToOne(targetEntity: Contexto::class, inversedBy: 'palavras')]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")] // Adicionando onDelete para remover palavras ao remover contexto
    private $contexto;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPalavra(): ?string
    {
        return $this->palavra;
    }

    public function setPalavra(string $palavra): self
    {
        $this->palavra = $palavra;

        return $this;
    }

    public function getContexto(): ?Contexto
    {
        return $this->contexto;
    }

    public function setContexto(?Contexto $contexto): self
    {
        $this->contexto = $contexto;

        return $this;
    }
}
