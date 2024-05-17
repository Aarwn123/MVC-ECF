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
        // Hasher le mot de passe avec PASSWORD_BCRYPT
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $data = new User(0, $username, $email, $hashedPassword); // Utilise le mot de passe haché
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

    // Récupérer l'utilisateur par e-mail
    $user = $userDAO->getOneByEmail($email);

    if ($user && password_verify($password, $user->getPassword())) {
        // Utilisateur trouvé et mot de passe vérifié
        $message = "Connexion réussie.";
        $_SESSION['user'] = $user->getUsername();
        header('Location: compte');
        exit;
    } else {
        // Identifiants incorrects
        $message = "Identifiants incorrects.";
    }
}

echo $twig->render('compte.html.twig', [
    'message' => $message
]);
