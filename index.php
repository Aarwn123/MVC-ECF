<?php

namespace Model\repository;


// ******************** Controller pricipal ***************************************
require_once './config/init.php';
require_once './model/entity/Acteur.php';
require_once './model/entity/Film.php';
require_once './model/entity/Role.php';
require_once './model/repository/ActeurDAO.php';
require_once './model/repository/RoleDAO';
require_once './model/repository/FilmDAO';




// Initialisation de l'environnement

// Load Our autoloader

require './config/init.php';



// ************         Affichage du header  ***************************************
require './controller/header.php';



// ************          Gestion de Routing ***************************************
$routes = [
    '/' => './controller/home.php',
    'compte' => './controller/compte.php',
    'home' => './controller/home.php',
    'creer' => './controller/creer.php',
    'delete' => './controller/delete.php',
];

$controller = isset($_GET['action']) ?  $_GET['action'] : '/';

if (array_key_exists($controller, $routes)) {
    require $routes[$controller];
} else {
    require 'controller/erreur.php';
}


$films = FilmDAO::getAll();

echo $twig->render(
    'index.html.twig',
    [
        'films' => $films
    ]
);

// ************          Affichage du footer  ***************************************
require './controller/footer.php';
