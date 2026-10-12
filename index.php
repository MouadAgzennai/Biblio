<?php
require __DIR__ . '/autoload.php';

function lireEntree(string $invite): ?string
{
    fwrite(STDOUT, $invite);
    $entree = fgets(STDIN);

    return $entree === false ? null : trim($entree);
}

function afficherLivres(array $livres): void
{
    if ($livres === []) {
        echo "Aucun livre à afficher.\n";
        return;
    }

    foreach ($livres as $livre) {
        echo $livre . "\n";
    }
}

echo "=== Bibliothèque ===\n";
$id = lireEntree("ID du membre : ");
if ($id === null) {
    exit(0);
}

$idMembre = filter_var($id, FILTER_VALIDATE_INT);
if ($idMembre === false) {
    fwrite(STDERR, "L'ID du membre doit être un entier.\n");
    exit(1);
}

$nomMembre = lireEntree("Nom du membre : ");
if ($nomMembre === null) {
    exit(0);
}
if ($nomMembre === '') {
    fwrite(STDERR, "Le nom du membre ne peut pas être vide.\n");
    exit(1);
}

$bibliotheque = new Bibliotheque();
$membre = new Membre($idMembre, $nomMembre);
echo "Bienvenue, " . $membre->getNom() . " !\n";

while (true) {
    echo "\n";
    echo "1 Ajouter\n";
    echo "2 Lister\n";
    echo "3 Rechercher\n";
    echo "4 Emprunter\n";
    echo "5 Rendre\n";
    echo "0 Quitter\n";

    $choix = lireEntree("Votre choix : ");
    if ($choix === null || $choix === '0') {
        echo "Au revoir.\n";
        break;
    }

    try {
        switch ($choix) {
            case '1':
                $isbn = lireEntree("ISBN : ");
                $titre = lireEntree("Titre : ");
                $auteur = lireEntree("Auteur : ");
                if ($isbn === null || $titre === null || $auteur === null) {
                    echo "Saisie interrompue.\n";
                    break;
                }
                if ($titre === '' || $auteur === '') {
                    echo "Le titre et l'auteur ne peuvent pas être vides.\n";
                    break;
                }

                $livre = new Livre($isbn, $titre, $auteur);
                $bibliotheque->ajouter($livre);
                echo "Livre ajouté.\n";
                break;

            case '2':
                afficherLivres($bibliotheque->tous());
                break;

            case '3':
                $mot = lireEntree("Mot à rechercher : ");
                if ($mot === null) {
                    echo "Saisie interrompue.\n";
                    break;
                }

                afficherLivres($bibliotheque->rechercher($mot));
                break;

            case '4':
                $isbn = lireEntree("ISBN du livre à emprunter : ");
                if ($isbn === null) {
                    echo "Saisie interrompue.\n";
                    break;
                }

                $livre = $bibliotheque->trouver($isbn);
                if ($livre === null) {
                    echo "Aucun livre ne correspond à cet ISBN.\n";
                    break;
                }

                $membre->emprunter($livre);
                echo "Livre emprunté.\n";
                break;

            case '5':
                $isbn = lireEntree("ISBN du livre à rendre : ");
                if ($isbn === null) {
                    echo "Saisie interrompue.\n";
                    break;
                }

                $livreEmprunte = null;
                foreach ($membre->getEmprunts() as $emprunt) {
                    if ($emprunt->getIsbn() === $isbn) {
                        $livreEmprunte = $emprunt;
                        break;
                    }
                }

                if ($livreEmprunte === null) {
                    echo "Ce membre n'a pas emprunté ce livre.\n";
                    break;
                }

                $membre->rendre($livreEmprunte);
                echo "Livre rendu.\n";
                break;

            default:
                echo "Choix invalide. Veuillez sélectionner une option du menu.\n";
        }
    } catch (Exception $exception) {
        echo "Erreur : " . $exception->getMessage() . "\n";
    }
}
