<?php
$membre = new Membre(42, 'Moussa');
verifier($membre->getId() === 42, 'L’identifiant du membre est conservé');
verifier($membre->getNom() === 'Moussa', 'Le nom du membre est conservé');
verifier($membre->getEmprunts() === [], 'Un nouveau membre n’a aucun emprunt');

$livreUn = new Livre('9782100545261', 'Livre un', 'Auteur un');
$livreDeux = new Livre('9780132350884', 'Livre deux', 'Auteur deux');
$livreTrois = new Livre('9780131103627', 'Livre trois', 'Auteur trois');
$livreQuatre = new Livre('9780321765723', 'Livre quatre', 'Auteur quatre');

$membre->emprunter($livreUn);
$membre->emprunter($livreDeux);
$membre->emprunter($livreTrois);
verifier(count($membre->getEmprunts()) === 3, 'Un membre peut emprunter jusqu’à trois livres');
verifier(!$livreUn->estDisponible(), 'Emprunter via le membre rend le livre indisponible');

$limiteRespectee = false;
try {
    $membre->emprunter($livreQuatre);
} catch (Exception $exception) {
    $limiteRespectee = true;
}
verifier($limiteRespectee, 'Un membre ne peut pas emprunter un quatrième livre');
verifier($livreQuatre->estDisponible(), 'Le livre reste disponible après refus du quatrième emprunt');

$autreMembre = new Membre(43, 'Autre membre');
$livreRefuse = false;
try {
    $autreMembre->rendre($livreUn);
} catch (Exception $exception) {
    $livreRefuse = true;
}
verifier($livreRefuse, 'Un membre ne peut pas rendre un livre emprunté par un autre membre');
verifier(!$livreUn->estDisponible(), 'Le livre reste emprunté après un retour refusé');

$membre->rendre($livreDeux);
verifier($livreDeux->estDisponible(), 'Rendre via le membre rend le livre disponible');
verifier(count($membre->getEmprunts()) === 2, 'Le livre rendu est retiré des emprunts du membre');
