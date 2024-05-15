<?php

namespace Model\repository;

use Model\repository\RoleDAO;

//On appelle la fonction getAll()
$roleDAO = new RoleDAO();

$roles = $roleDAO->getAll();

unset($_SESSION['user']);
// $_SESSION['user'] = 'vince@afpa.com';

//On affiche le template Twig correspondant
echo $twig->render('home.html.twig', ['roles' => $roles]);
