<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
class Contexto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nome;

    #[ORM\OneToMany(targetEntity: Palavra::class, mappedBy: 'contexto', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private $palavras;

    public function __construct()
    {
        $this->palavras = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * @return Collection|Palavra[]
     */
    public function getPalavras(): Collection
    {
        return $this->palavras;
    }

    public function addPalavra(Palavra $palavra): self
    {
        if (!$this->palavras->contains($palavra)) {
            $this->palavras[] = $palavra;
            $palavra->setContexto($this);
        }

        return $this;
    }

    public function removePalavra(Palavra $palavra): self
    {
        if ($this->palavras->removeElement($palavra)) {
            if ($palavra->getContexto() === $this) {
                $palavra->setContexto(null);
            }
        }

        return $this;
    }
}
