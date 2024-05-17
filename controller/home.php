<?php



use Model\repository\FilmDAO;

// require_once './model/repository/FilmDAO.php';



//On appelle la fonction getAll()
$filmDAO = new FilmDAO();
$films = $filmDAO->getAll();
array_filter($films);


// unset($_SESSION['user']);
// $_SESSION['user'] = 'vince@afpa.com';

//On affiche le template Twig correspondant
// var_dump($films);

// var_dump($films);
echo $twig->render('home.html.twig', ['films' => $films]);
