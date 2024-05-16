<?php

namespace Model\repository;






use Model\entity\Film;
use Model\entity\Role;
use Model\repository\Dao;

class FilmDAO extends Dao
{
    public static function getAll(): array
    {
        $query = self::$bdd->prepare("SELECT film.id, film.titre, film.realisateur, film.affiche, film.annee, acteur.nom AS nom_acteur, acteur.prenom AS prenom_acteur, acteur.id AS id_acteur, role.id AS id_role, role.id_acteur AS id_acteur_role, role.id_film AS id_film_role, role.personnage as personnage_role 
                                  FROM film 
                                  INNER JOIN role ON film.id = role.id_film
                                  INNER JOIN acteur ON role.id_acteur = acteur.id");

        $query->execute();
        $films = [];

        while ($data = $query->fetch()) {
            // Création d'un nouvel objet Film
            $film = new Film($data['id'], $data['titre'], $data['realisateur'], $data['affiche'], $data['annee'], [], []);

            // Création d'un nouvel objet role
            $role = new Role($data['id_role'], $data['id_acteur_role'], $data['id_film_role'], $data['personnage_role']);

            // Création d'un nouvel objet Acteur avec les noms récupérés
            // $acteur = new Acteur($data['id_acteur'], $data['nom_acteur'], $data['prenom_acteur']);

            // Ajout du role au film
            // $film->addRole($role);

            // Ajout du film à la liste des films
            $films[] = $film;
        }
        return $films;
    }

    //Ajouter un film
    public static function addOne($data): bool
    {

        $requete = 'INSERT INTO film (titre, realisateur, affiche, annee, genre, role) VALUES (:titre , :realisateur, :affiche, :annee, :role)';
        $valeurs = ['titre' => $data->getTitre(), 'realisateur' => $data->getRealisateur(), 'affiche' => $data->getAffiche(), 'annee' => $data->getAnnee(), 'role' => $data->getRole()];
        $insert = self::$bdd->prepare($requete);
        return $insert->execute($valeurs);
    }

    //Récupérer plus d'info sur 1 film
    public static function getOne(int $id): Film
    {
        $query = self::$bdd->prepare('SELECT * FROM film WHERE id = :id_film');
        $query->execute(array(':id_film' => $id));
        $data = $query->fetch();
        return new Film($data['id'], $data['titre'], $data['realisateur'], $data['affiche'], $data['annee'], $data['role']);
    }

    //Deleter 1 film par son id
    public static function deleteOne(int $id): bool
    {
        $query = self::$bdd->prepare('DELETE FROM film WHERE film.id = :idFilm');
        $query->execute(array(':idFilm' => $id));
        return $query->rowCount() == 1 ? true : false;
    }
}