<?php

use Model\repository\OffreDAO;

$message = "";
if (isset($_POST['id'])) {
    //On appelle la fonction deleteOne()
    $offreDao = new OffreDAO();

    $status = $offreDao->deleteOne((int) $_POST['id']);

    $message = $status ? "Suppression OK" : "Erreur Suppression";
}

echo $twig->render(
    'delete.html.twig',
    [
        'message' => $message
    ]
);
