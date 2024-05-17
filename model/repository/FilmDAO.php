<?php

namespace Model\repository;





use Model\entity\Acteur;
use Model\entity\Film;
use Model\entity\Role;
use Model\repository\Dao;

class FilmDAO extends Dao
{
    // public static function getAll($recherche = ""): array
    // {
    //     $query = self::$bdd->prepare("SELECT film.id, film.titre, film.realisateur, film.affiche, film.annee, acteur.nom AS nom_acteur, acteur.prenom AS prenom_acteur, acteur.id AS id_acteur, role.id AS id_role, role.id_acteur AS id_acteur_role, role.id_film AS id_film_role, role.personnage as personnage_role 
    //                               FROM film 
    //                               INNER JOIN role ON film.id = role.id_film
    //                               INNER JOIN acteur ON role.id_acteur = acteur.id
    //                               WHERE film.titre LIKE :recherche
    //                               ORDER BY id");

    //     $recherche = $recherche . '%';

    //     $query->execute(['recherche' => $recherche]);
    //     $films = [];
    //     $precedent = null;


    //     while ($data = $query->fetch()) {
    //         // Création d'un nouvel objet Film
    //         if ($data['id'] != $precedent) {
    //             $film = new Film($data['id'], $data['titre'], $data['realisateur'], $data['affiche'], $data['annee']);
    //             $precedent = $data['id'];

    //             $films[] = $film;
    //             // Ajout du film à la liste des films
    //         }


    //         // Création d'un nouvel objet Acteur avec les noms récupérés
    //         $acteur = new Acteur($data['id_acteur'], $data['nom_acteur'], $data['prenom_acteur']);

    //         // Création d'un nouvel objet role
    //         $role = new Role($data['id_role'],  $data['personnage_role'], $acteur);

    //         // Ajout de l'acteur au rôle
    //         // $role->setActeur($acteur);
    //         // Ajout du role au film    ya un NULL ici !!!!
    //         $film->addRole($role);
    //         // var_dump($role);
    //     }

    //     return $films;
    // }

    public static function getAll($recherche = ""): array
    {
        // Préparation de la requête SQL avec un paramètre de recherche
        $query = self::$bdd->prepare("SELECT film.id, film.titre, film.realisateur, film.affiche, film.annee, acteur.nom AS nom_acteur, acteur.prenom AS prenom_acteur, acteur.id AS id_acteur, role.id AS id_role, role.id_acteur AS id_acteur_role, role.id_film AS id_film_role, role.personnage as personnage_role 
                                      FROM film 
                                      INNER JOIN role ON film.id = role.id_film
                                      INNER JOIN acteur ON role.id_acteur = acteur.id
                                    --   On défini sur quoi on veut établir la recherche. Ici, le titre du film. On y associe le mot clé 'recherche'
                                      WHERE film.titre LIKE :recherche
                                      ORDER BY film.id");

        // Ajouter le caractère '%' pour la recherche partielle
        $recherche = '%' . $recherche . '%';

        // Exécution de la requête avec le paramètre de recherche
        $query->execute(['recherche' => $recherche]);

        $films = [];
        $precedent = null;

        while ($data = $query->fetch()) {
            // Création d'un nouvel objet Film si l'ID est différent du précédent
            if ($data['id'] != $precedent) {
                $film = new Film($data['id'], $data['titre'], $data['realisateur'], $data['affiche'], $data['annee']);
                $precedent = $data['id'];
                $films[] = $film;
            }

            // Création d'un nouvel objet Acteur
            $acteur = new Acteur($data['id_acteur'], $data['nom_acteur'], $data['prenom_acteur']);

            // Création d'un nouvel objet Role
            $role = new Role($data['id_role'], $data['personnage_role'], $acteur);

            // Ajout du rôle au film
            $film->addRole($role);
        }

        return $films;
    }

    //Ajouter une offre
    public static function addOne($data): bool
    {

        $requete = 'INSERT INTO film (titre, realisateur, affiche, annee, genre, role) VALUES (:titre , :realisateur, :affiche, :annee, :genre,  :role)';
        $valeurs = ['titre' => $data->getTitre(), 'realisateur' => $data->getRealisateur(), 'affiche' => $data->getAffiche(), 'annee' => $data->getAnnee()];
        $insert = self::$bdd->prepare($requete);
        return $insert->execute($valeurs);
    }

    //Récupérer plus d'info sur 1 offre
    public static function getOne(int $id): Film
    {
        $query = self::$bdd->prepare('SELECT * FROM film WHERE id = :id_film');
        $query->execute(array(':id_film' => $id));
        $data = $query->fetch();
        return new Film($data['id'], $data['titre'], $data['realisateur'], $data['affiche'], $data['annee']);
    }

    //Deleter 1 offre par son id
    public static function deleteOne(int $id): bool
    {
        $query = self::$bdd->prepare('DELETE FROM film WHERE film.id = :idFilm');
        $query->execute(array(':idFilm' => $id));
        return $query->rowCount() == 1 ? true : false;
    }
}
