
<?php

use Model\repository\FilmDAO;

//On appelle la fonction getAll()
$filmDAO = new FilmDAO();
if (isset($_POST['recherche'])) {
    $films = $filmDAO->getAll($_POST['recherche']);
} else {
    $films = $filmDAO->getAll();
}

//On affiche le template Twig correspondant
echo $twig->render('home.html.twig', ['films' => $films,]);
