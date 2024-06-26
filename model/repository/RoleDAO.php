<?php

namespace Model\repository;



use Model\entity\Role;
use Model\repository\Dao;


class RoleDAO extends Dao
{

    public static function getRolesFromMatrix(): array
    {
        $sql = "SELECT acteur.nom, acteur.prenom, role.personnage, film.titre
                FROM role
                JOIN acteur ON role.id_acteur = acteur.id
                JOIN film ON role.id_film = film.id
                WHERE film.titre = 'Matrix'";
        $query = self::$bdd->prepare($sql);
        $query->execute();
        $roles = array();

        while ($data = $query->fetch()) {
            $roles[] = new Role($data['id'], $data['nom'], $data['prenom']);
        }
        return $roles;
    }
    //Récupérer toutes les offres
    public static function getAll(): array
    {

        $query = self::$bdd->prepare("SELECT  id_acteur, id_film, id, personnage  FROM role");
        $query->execute();
        $role = array();

        while ($data = $query->fetch()) {
            $acteur[] = new Role($data['id_acteur'], $data['id_film'], $data['id'], $data['personnage']);
        }
        return ($role);
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
    public static function getOne(int $id): Role
    {
        $query = self::$bdd->prepare('SELECT * FROM role WHERE id = :id_role');
        $query->execute(array(':id_role' => $id));
        $data = $query->fetch();
        return new Role($data['id'], $data['nom'], $data['prenom']);
    }

    //Deleter 1 offre par son id
    public static function deleteOne(int $id): bool
    {
        $query = self::$bdd->prepare('DELETE FROM role WHERE role.id = :idRole');
        $query->execute(array(':idRole' => $id));
        return $query->rowCount() == 1 ? true : false;
    }
}