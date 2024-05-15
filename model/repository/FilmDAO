<?php

namespace Model\repository;



use Model\entity\Film;
use Model\repository\Dao;

class FilmDAO extends Dao
{

    //Récupérer toutes les offres
    public static function getAll(): array
    {

        $query = self::$bdd->prepare("SELECT id, titre, realisateur, affiche, annee  FROM film");
        $query->execute();
        $film = array();

        while ($data = $query->fetch()) {
            $film[] = new Film($data['id'], $data['titre'], $data['realisateur'], $data['affiche'], $data['annee']);
        }
        return ($film);
    }

    //Ajouter une offre
    public static function addOne($data): bool
    {

        $requete = 'INSERT INTO film (titre, realisateur, affiche, annee) VALUES (:titre , :realisateur, :affiche, :annee)';
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
        $query = self::$bdd->prepare('DELETE FROM film WHERE acteur.id = :idFilm');
        $query->execute(array(':idFilm' => $id));
        return $query->rowCount() == 1 ? true : false;
    }
}
