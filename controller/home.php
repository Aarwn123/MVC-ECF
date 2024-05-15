<?php

namespace Model\repository;

use Model\repository\RoleDAO;

//On appelle la fonction getAll()
$filmDAO = new FilmDAO();
$films = $filmDAO->getAll();

$acteurDAO = new ActeurDAO();
$acteurs = $acteurDAO->getAll();

unset($_SESSION['user']);
// $_SESSION['user'] = 'vince@afpa.com';

//On affiche le template Twig correspondant

echo $twig->render('home.html.twig', ['films' => $films]);
echo $twig->render('home.html.twig', ['acteurs' => $acteurs]);
