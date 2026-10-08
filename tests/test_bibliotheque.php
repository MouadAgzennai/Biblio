<?php
$bibliotheque = new Bibliotheque();
$livreAlgo = new Livre('9782100545261', 'Introduction aux algorithmes', 'Thomas Cormen');
$livrePHP = new Livre('9780132350884', 'Clean Code', 'Robert Martin');
$livreReseaux = new Livre('9780131103627', 'The C Programming Language', 'Brian Kernighan');

verifier($bibliotheque->compter() === 0, 'Une bibliothèque vide ne contient aucun livre');
verifier($bibliotheque->tous() === [], 'Tous les livres sont vides au départ');

$bibliotheque->ajouter($livreAlgo);
$bibliotheque->ajouter($livrePHP);
$bibliotheque->ajouter($livreReseaux);

verifier($bibliotheque->compter() === 3, 'Le nombre de livres ajoutés est compté');
verifier(count($bibliotheque->tous()) === 3, 'Tous les livres ajoutés sont retournés');
verifier($bibliotheque->trouver('9780132350884') === $livrePHP, 'Un livre est trouvé par ISBN');
verifier($bibliotheque->trouver('0000000000') === null, 'Un ISBN absent retourne null');

$doublonRefuse = false;
try {
    $bibliotheque->ajouter(new Livre('9782100545261', 'Autre titre', 'Autre auteur'));
} catch (InvalidArgumentException $exception) {
    $doublonRefuse = true;
}
verifier($doublonRefuse, 'Un ISBN déjà présent ne peut pas être ajouté');

$resultatsTitre = $bibliotheque->rechercher('ALGORITHMES');
verifier(count($resultatsTitre) === 1 && $resultatsTitre[0] === $livreAlgo, 'La recherche dans le titre ignore la casse');

$resultatsAuteur = $bibliotheque->rechercher('rOBERT');
verifier(count($resultatsAuteur) === 1 && $resultatsAuteur[0] === $livrePHP, 'La recherche dans l’auteur ignore la casse');

verifier($bibliotheque->rechercher('introuvable') === [], 'Une recherche sans résultat retourne un tableau vide');
