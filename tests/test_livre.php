<?php
$livre = new Livre('9782100545261', 'Algo', 'Cormen');
verifier($livre->estDisponible(), 'Un nouveau livre est disponible');
$livre->emprunter();
verifier(!$livre->estDisponible(), 'Après emprunt, le livre est indisponible');

?>