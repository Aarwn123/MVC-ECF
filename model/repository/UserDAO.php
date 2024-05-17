<?php

namespace Model\repository;


use Model\entity\User;
use Model\repository\Dao;

class UserDAO extends Dao
{
    // Créer un compte
    public static function addOne($data): bool
    {
        $requete = 'INSERT INTO user (username, email, password) VALUES (:username , :email, :password)';
        $valeurs = ['username' => $data->getUsername(), 'email' => $data->getEmail(), 'password' => $data->getPassword()];
        $insert = self::$bdd->prepare($requete);
        return $insert->execute($valeurs);
    }

    // Recherche d'un compte par e-mail
    public static function getByEmail($email): ?User
    {
        // Requête SQL pour récupérer l'utilisateur en fonction de son e-mail
        $requete = 'SELECT * FROM user WHERE email = :email';
        $valeurs = ['email' => $email];
        $query = self::$bdd->prepare($requete);
        $query->execute($valeurs);
        $result = $query->fetch(\PDO::FETCH_ASSOC);

        if ($result) {
            // Création d'un objet User avec les données récupérées
            return new User($result['id'], $result['username'], $result['email'], $result['password']);
        } else {
            return null;
        }
    }

    // Vérifie si une adresse e-mail existe déjà dans la base de données
    public static function emailExists($email): bool
    {
        // Requête SQL pour vérifier si l'adresse e-mail existe déjà
        $requete = 'SELECT * FROM user WHERE email = :email';
        $valeurs = ['email' => $email];
        $query = self::$bdd->prepare($requete);
        $query->execute($valeurs);
        // Récupération du résultat
        $result = $query->fetchColumn();
        // Retourne true si l'adresse e-mail existe déjà, sinon false
        return $result > 0;
    }


    // Fonctions non utilisées


    //Récupérer toutes les offres
    public static function getAll(): array
    {

        $query = self::$bdd->prepare("SELECT  id, username, email, password  FROM user");
        $query->execute();
        $user = array();

        while ($data = $query->fetch()) {
            $acteur[] = new User($data['id'], $data['username'], $data['email'], $data['password']);
        }
        return ($user);
    }


    //Deleter 1 offre par son id
    public static function deleteOne(int $id): bool
    {
        $query = self::$bdd->prepare('DELETE FROM user WHERE id = :id');
        $query->execute(array(':id' => $id));
        return $query->rowCount() == 1 ? true : false;
    }

    //Récupérer plus d'info sur 1 utilisateur par son id
    public static function getOne(int $id): User
    {
        $query = self::$bdd->prepare('SELECT * FROM user WHERE id = :id');
        $query->execute(array(':id' => $id));
        $data = $query->fetch();

        if ($data) {
            return new User($data['id'], $data['username'], $data['email'], $data['password']);
        } else {
            return null;
        }
    }
}
