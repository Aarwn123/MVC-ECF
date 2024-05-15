<?php

namespace Model\repository;



use Model\entity\Acteur;
use Model\repository\Dao;

class ActeurDAO extends Dao
{

    //Récupérer toutes les offres
    public static function getAll(): array
    {

        $query = self::$bdd->prepare("SELECT id, nom, prenom  FROM acteur");
        $query->execute();
        $acteur = array();

        while ($data = $query->fetch()) {
            $acteur[] = new Acteur($data['id'], $data['nom'], $data['prenom']);
        }
        return ($acteur);
    }

    //Ajouter une offre
    public static function addOne($data): bool
    {

        $requete = 'INSERT INTO acteur (nom, prenom) VALUES (:nom , :prenom)';
        $valeurs = ['nom' => $data->getNom(), 'prenom' => $data->getPrenom()];
        $insert = self::$bdd->prepare($requete);
        return $insert->execute($valeurs);
    }

    //Récupérer plus d'info sur 1 offre
    public static function getOne(int $id): Acteur
    {
        $query = self::$bdd->prepare('SELECT * FROM acteur WHERE id = :id_acteur');
        $query->execute(array(':id_acteur' => $id));
        $data = $query->fetch();
        return new Acteur($data['id'], $data['nom'], $data['prenom']);
    }

    //Deleter 1 offre par son id
    public static function deleteOne(int $id): bool
    {
        $query = self::$bdd->prepare('DELETE FROM acteur WHERE acteur.id = :idActeur');
        $query->execute(array(':idActeur' => $id));
        return $query->rowCount() == 1 ? true : false;
    }
}
