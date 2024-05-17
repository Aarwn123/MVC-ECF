<?php

use Model\entity\Film;
use Model\repository\FilmDAO;
use Model\entity\Role;
use Model\repository\RoleDAO;
use Model\entity\Acteur;
use Model\repository\ActeurDAO;


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Récupérer les données du formulaire
    $titre = htmlspecialchars($_POST['titre']);
    $realisateur = htmlspecialchars($_POST['realisateur']);
    $affiche = htmlspecialchars($_POST['affiche']);
    $annee = (int) $_POST['annee'];
    $roles = $_POST['roles'] ?? [];

    // Créer un nouvel objet Film
    $film = new Film(null, $titre, $realisateur, $affiche, $annee,$role);
    
    // Initialiser FilmDAO
    $filmDAO = new FilmDAO();

    // Ajouter le film à la base de données
    if ($filmDAO->addOne($film)) {
        // Récupérer l'ID du film ajouté
        $filmId = $filmDAO->getLastInsertId();
        $film->setId($filmId);

        // Ajouter les rôles associés si le film est ajouté avec succès
        $roleDAO = new RoleDAO();
        $acteurDAO = new ActeurDAO();
        foreach ($roles as $roleData) {
            $personnage = htmlspecialchars($roleData['personnage']);
            $nom = htmlspecialchars($roleData['nom']);
            $prenom = htmlspecialchars($roleData['prenom']);

            // Vérifier si l'acteur existe déjà
            // $acteur = $acteurDAO->getByName($nom, $prenom);
            // if (!$acteur) {
            //     // Si l'acteur n'existe pas, le créer
            //     $acteur = new Acteur(null, $nom, $prenom);
            //     $acteurDAO->addOne($acteur);
            //     $acteur = $acteurDAO->getByName($nom, $prenom); // Obtenez l'objet acteur complet
            // }

            // // Créer et ajouter le rôle
            // $role = new Role(null, $personnage, $acteur);
            // $roleDAO->addOne($role);
        }
        // Rediriger vers une page de succès
        header('Location:creer');
        exit;
    } else {
        echo "Erreur lors de l'ajout du film.";
    }
}

// Rendre le template Twig avec le message de feedback
echo $twig->render('creer.html.twig', []);




// il manque la partie avec la condition pour empêcher les doublons ( manque de temps :/)

?>
