<?php
require_once '../model/repository/SPDO.php';


// Création de compte

// Vérification si le formulaire de création de compte a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    // Récupération des données du formulaire
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Vérification si les mots de passe correspondent
    if ($password !== $confirmPassword) {
        echo "Les mots de passe ne correspondent pas.";
        exit;
    }

    // Connexion à la base de données depuis SPDO
    $pdo = SPDO::getInstance()->getPdo();

    // Préparation de la requête SQL pour insérer les données dans la base de données
    $sql = "INSERT INTO user (username, email, password) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username, $email, $password]);

    // Vérification si l'insertion a réussi
    if ($stmt->rowCount() > 0) {
        echo "Compte créé avec succès.";
    } else {
        echo "Erreur lors de la création du compte.";
    }
}


// Identification

// Vérification si le formulaire de connexion a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    // Récupération des données du formulaire
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Connexion à la base de données depuis SPDO
    $pdo = SPDO::getInstance()->getPdo();

    // Préparation de la requête SQL pour vérifier l'existence du compte
    $sql = "SELECT username FROM user WHERE email = ? AND password = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email, $password]);

    // Vérification si un compte correspondant a été trouvé
    if ($stmt->rowCount() > 0) {
        // L'utilisateur est correctement connecté
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $username = $row['username'];
        echo "Connexion réussie. Bienvenue, " . $username . " !";
        // Redirection de l'utilisateur vers une autre page
        header('Location: ../view/compte.html.twig');
    } else {
        echo "Identifiants incorrects.";
    }
}
