<?php

use Model\entity\User;
use Model\repository\UserDAO;

$userDAO = new UserDAO();
$message = "";


// Connexion

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Vérifier les champs et la correspondance des mots de passe
    if ($username === '') {
        $message = "Veuillez entrer un nom d'utilisateur";
    } elseif (!preg_match("/^\S+@\S+\.\S+$/", $email)) {
        $message = "Adresse e-mail invalide.";
    } elseif (UserDAO::emailExists($email)) {
        $message = "Un compte avec cette adresse e-mail existe déjà.";
    } elseif (!preg_match("/^.{4,}$/", $password)) {
        $message = "Le mot de passe doit faire au moins 4 caractères.";
    } elseif ($password !== $confirmPassword) {
        $message = "Les mots de passe ne correspondent pas.";
    } else {
        // Hasher le mot de passe avec PASSWORD_BCRYPT
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Créer un nouvel utilisateur avec le mot de passe haché
        $user = new User(0, $username, $email, $hashedPassword);

        // Ajouter l'utilisateur à la base de données
        if ($userDAO->addOne($user)) {
            $message = 'Compte créé avec succès.';
        } else {
            $message = "Erreur lors de la création du compte.";
        }
    }
}

// Identification

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    // Traitement pour la connexion d'un utilisateur
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = $userDAO->getByEmail($email);

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
