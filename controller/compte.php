<?php

//unset($_SESSION['user']);

use Model\entity\User;
use Model\repository\UserDAO;

$userDAO = new UserDAO();
$message = "";
$erreurIdentifiants = false; // Pour contrôler la création du compte

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($username === '') {
        $message = "Veuillez entrer un nom d'utilisateur";
        $erreurIdentifiants = true;
    } elseif (!preg_match("/^\S+@\S+\.\S+$/", $email)) {
        $message = "Adresse e-mail invalide.";
        $erreurIdentifiants = true;
    } elseif (UserDAO::emailExists($email)) {
        $message = "Un compte avec cette adresse e-mail existe déjà.";
        $erreurIdentifiants = true;
    } elseif (!preg_match("/^.{4,}$/", $password)) {
        $message = "Le mot de passe doit faire au moins 4 caractères.";
        $erreurIdentifiants = true;
    } elseif ($password !== $confirmPassword) {
        $message = "Les mots de passe ne correspondent pas.";
        $erreurIdentifiants = true;
    }

    if (!$erreurIdentifiants) {
        $data = new User(0, $username, $email, $password);
        if ($userDAO->addOne($data)) {
            $message = 'Compte créé';
            header('Location: compte');
            exit;
        } else {
            $message = "Erreur lors de la création du compte.";
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = $userDAO->getOneByEmailAndPassword($email, $password);

    if ($user) {
        $message = "Connexion réussie.";
        $_SESSION['user'] = $user->getUsername();
        header('Location: compte');
        exit;
    } else {
        $message = "Identifiants incorrects.";
    }
}

echo $twig->render('compte.html.twig', [
    'message' => $message
]);
