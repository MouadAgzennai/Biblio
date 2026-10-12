<?php
class Bibliotheque
{
    /** @var Livre[] */
    private array $livres = [];

    public function ajouter(Livre $livre): void
    {
        if ($this->trouver($livre->getIsbn()) !== null) {
            throw new InvalidArgumentException("Un livre avec cet ISBN existe déjà");
        }

        $this->livres[] = $livre;
    }

    public function trouver(string $isbn): ?Livre
    {
        foreach ($this->livres as $livre) {
            if ($livre->getIsbn() === $isbn) {
                return $livre;
            }
        }

        return null;
    }

    public function tous(): array
    {
        return $this->livres;
    }

    public function compter(): int
    {
        return count($this->livres);
    }

    public function rechercher(string $mot): array
    {
        $resultats = [];

        foreach ($this->livres as $livre) {
            if (
                stripos($livre->getTitre(), $mot) !== false
                || stripos($livre->getAuteur(), $mot) !== false
            ) {
                $resultats[] = $livre;
            }
        }

        return $resultats;
    }
}
