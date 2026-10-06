# Biblio

Groupe : DevopsTeam
Etudiant A : Mouad Agzennai Bakhouch
Etudiant B : Moussa El Moussaoui

Application PHP en ligne de commande pour gérer une bibliothèque (livres, membres, emprunts).

## Contrat d'interface

- **Livre** : `__construct($isbn, $titre, $auteur)`, `getIsbn()`, `getTitre()`, `getAuteur()`, `estDisponible()`, `emprunter()`, `rendre()`, `__toString()`
- **Bibliotheque** : `ajouter(Livre)`, `trouver($isbn)`, `tous()`, `compter()`, `rechercher($mot)`
- **Membre** : `__construct($id, $nom)`, `getId()`, `getNom()`, `emprunter(Livre)`, `rendre(Livre)`, `getEmprunts()`

## Tests

    php tests/run.php