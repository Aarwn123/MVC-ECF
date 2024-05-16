<?php

use Model\entity\Film;
use Model\repository\FilmDAO;
// use Model\entity\Role;
use Model\repository\RoleDAO;
use Model\entity\Acteur;
use Model\repository\ActeurDAO;

// Fonction de validation des données
function validate_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Récupérer les données du formulaire
    $titre = validate_input($_POST['titre']);
    $realisateur = validate_input($_POST['realisateur']);
    $affiche = validate_input($_POST['affiche']);
    $annee = validate_input($_POST['annee']);
    $roles = $_POST['roles'] ?? [];

    // Créer un nouvel objet Film
    $film = new Film(null, $titre, $realisateur, $affiche, $annee);

    // Initialiser FilmDAO
    $filmDAO = new FilmDAO();

    // Ajouter le film à la base de données
    if ($filmDAO->addOne($film)) {
        // Ajouter les rôles associés si le film est ajouté avec succès
        $roleDAO = new RoleDAO();
        $acteurDAO = new ActeurDAO();
        foreach ($roles as $roleData) {
            $personnage = validate_input($roleData['personnage']);
            $nom = validate_input($roleData['nom']);
            $prenom = validate_input($roleData['prenom']);

            // Vérifier si l'acteur existe déjà
            $acteur = $acteurDAO->getByName($nom, $prenom);
            if (!$acteur) {
                // Si l'acteur n'existe pas, le créer
                $acteur = new Acteur(null, $nom, $prenom);
                $acteurDAO->addOne($acteur);
            }

            // Créer et ajouter le rôle
            // $role = new Role(null, $film->getId(), $personnage, $acteur->getId());
            // $roleDAO->addOne($role);
        }
        // Rediriger vers une page de succès
        header('Location: ../view/success.html.twig');
        exit;
    } else {
        echo "Erreur lors de l'ajout du film.";
    }
}




// use Model\entity\Film;
// use Model\repository\FilmDAO;
// use Model\entity\Role;
// use Model\repository\RoleDAO;



// if (isset($_POST['titre']) && isset($_POST['realisateur']) && isset($_POST['affiche']) && isset($_POST['annee']) && isset($_POST['genre'])) {
//     // Créer un nouvel objet Film
//     $film = new Film($_POST['titre'], $_POST['realisateur'], $_POST['affiche'], $_POST['annee'], $_POST['genre'], $_POST['role']);
    
//     // Ajouter le film à la base de données
//     $filmDAO = new FilmDAO();
//     if ($filmDAO::addOne($film)) {
//         // Ajouter les rôles associés si le film est ajouté avec succès
//         if (isset($_POST['roles'])) {
//             $roleDAO = new RoleDAO();
//             foreach ($_POST['roles'] as $roleData) {
//                 $role = new Role($film->getId(), $roleData['personnage'], $roleData['nom'], $roleData['prenom']);
//                 $roleDAO::addOne($role);
//             }
//         }
//         $feedback = "Ajout OK";
//     } else {
//         $feedback = "Erreur Ajout";
//     }
// } else {
//     $feedback = "Tous les champs ne sont pas remplis.";
// }


// // Rendre le template Twig avec le message de feedback
// echo $twig->render('creer.html.twig', [
    
// ]); 

// 

// use Model\entity\Film;
// use Model\repository\FilmDAO;
// use Model\entity\Role;
// use Model\repository\RoleDAO;



// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
//     // Récupérer les données du formulaire
//     $titre = ($_POST['titre']);
//     $realisateur = ($_POST['realisateur']);
//     $affiche = ($_POST['affiche']);
//     $annee = ($_POST['annee']);
//     $roles = $_POST['roles'] ?? [];
    
//     // Ajouter le film à la base de données
//     $filmDAO = new FilmDAO();
//     if ($filmDAO::addOne($film)) {
//         // Ajouter les rôles associés si le film est ajouté avec succès
//         if (isset($_POST['roles'])) {
//             $roleDAO = new RoleDAO();
//             foreach ($_POST['roles'] as $roleData) {
//                 $role = new Role($film->getId(), $roleData['personnage'], $roleData['nom'], $roleData['prenom']);
//                 $roleDAO::addOne($role);
//             }
//         }
//         $feedback = "Ajout OK";
//     } else {
//         $feedback = "Erreur Ajout";
//     }
// } else {
//     $feedback = "Tous les champs ne sont pas remplis.";
// }


// // Rendre le template Twig avec le message de feedback
echo $twig->render('creer.html.twig', [
    
]);