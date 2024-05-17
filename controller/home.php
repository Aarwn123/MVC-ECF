<?php



use Model\repository\FilmDAO;

// require_once './model/repository/FilmDAO.php';



//On appelle la fonction getAll()
$filmDAO = new FilmDAO();
if (isset($_POST['recherche'])) {
    $films = $filmDAO->getAll($_POST['recherche']);
} else {
    $films = $filmDAO->getAll();
}





// unset($_SESSION['user']);
// $_SESSION['user'] = 'vince@afpa.com';

//On affiche le template Twig correspondant
// var_dump($films);

// echo '<pre>';
// print_r($films);
// echo '</pre>';
echo $twig->render('home.html.twig', ['films' => $films,]);
