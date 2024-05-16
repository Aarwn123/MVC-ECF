<?php

namespace Model\repository;


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

}
    // Connexion à un compte
    /*       public static function getOne(int $id): User
    {
        $query = self::$bdd->prepare('SELECT')
    }*/
