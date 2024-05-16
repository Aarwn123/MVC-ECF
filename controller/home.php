<?php

namespace Model\repository;


use Model\repository\FilmDAO;


//On appelle la fonction getAll()
$filmDAO = new FilmDAO();
$films = $filmDAO->getAll();


// unset($_SESSION['user']);
// $_SESSION['user'] = 'vince@afpa.com';

//On affiche le template Twig correspondant

echo $twig->render('home.html.twig', ['films' => $films]);
