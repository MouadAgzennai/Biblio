<?php
class Membre
{
    private int $id;
    private string $nom;
    /** @var Livre[] */
    private array $emprunts = [];

    public function __construct(int $id, string $nom)
    {
        $this->id = $id;
        $this->nom = $nom;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function emprunter(Livre $livre): void
    {
        if (count($this->emprunts) >= 3) {
            throw new Exception("Un membre ne peut pas emprunter plus de trois livres");
        }

        $livre->emprunter();
        $this->emprunts[] = $livre;
    }

    public function rendre(Livre $livre): void
    {
        foreach ($this->emprunts as $index => $emprunt) {
            if ($emprunt === $livre) {
                $livre->rendre();
                array_splice($this->emprunts, $index, 1);
                return;
            }
        }

        throw new Exception("Ce membre n'a pas emprunté ce livre");
    }

    public function getEmprunts(): array
    {
        return $this->emprunts;
    }
}
