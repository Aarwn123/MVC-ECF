<?php

// require_once '../model/repository/SPDO.php';
// require_once '../model/repository/Dao.php';
// require_once '../model/repository/UserDAO.php';
// require_once '../model/entity/User.php';





use Model\entity\User;
use Model\repository\UserDAO;

// Obtention de l'instance de UserDAO
$userDAO = new UserDAO();

// Création de compte
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($password !== $confirmPassword) {
        echo "Les mots de passe ne correspondent pas.";
        exit;
    }

    $data = new User($username, $email, $password);

    if ($userDAO->addOne($data)) {
        header('Location: ../view/creer.html.twig');
    } else {
        echo "Erreur lors de la création du compte.";
    }
}
/*
// Identification
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = $userDAO->getOne($email, $password);

    if ($user) {
        echo "Connexion réussie. Vous pouvez rediriger l'utilisateur.";
        // Redirection de l'utilisateur
        ;
        // exit;
    } else {
        echo "Identifiants incorrects.";
    }
}
*/

echo $twig->render('compte.html.twig', ['user' => $userDAO]);