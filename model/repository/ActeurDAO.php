<?php

namespace Model\repository;

use Model\entity\Acteur;

class ActeurDAO extends Dao
{
    // Récupérer tous les acteurs
    public static function getAll(): array
    {
        $query = self::$bdd->prepare("SELECT id, nom, prenom FROM acteur");
        $query->execute();
        $acteurs = array();

        while ($data = $query->fetch()) {
            $acteurs[] = new Acteur($data['id'], $data['nom'], $data['prenom']);
        }
        return $acteurs;
    }

    // Ajouter un acteur
    public static function addOne($data): bool
    {
        $requete = 'INSERT INTO acteur (nom, prenom) VALUES (:nom, :prenom)';
        $valeurs = ['nom' => $data->getNom(), 'prenom' => $data->getPrenom()];
        $insert = self::$bdd->prepare($requete);
        return $insert->execute($valeurs);
    }

    // Récupérer un acteur par son ID
    public static function getOne(int $id): Acteur
    {
        $query = self::$bdd->prepare('SELECT * FROM acteur WHERE id = :id_acteur');
        $query->execute([':id_acteur' => $id]);
        $data = $query->fetch();
        return new Acteur($data['id'], $data['nom'], $data['prenom']);
    }

    // Récupérer un acteur par son nom et prénom
    public static function getByName(string $nom, string $prenom): ?Acteur
    {
        $query = self::$bdd->prepare('SELECT * FROM acteur WHERE nom = :nom AND prenom = :prenom');
        $query->execute([':nom' => $nom, ':prenom' => $prenom]);
        $data = $query->fetch();
        if ($data) {
            return new Acteur($data['id'], $data['nom'], $data['prenom']);
        }
        return null;
    }

    // Supprimer un acteur par son ID
    public static function deleteOne(int $id): bool
    {
        $query = self::$bdd->prepare('DELETE FROM acteur WHERE acteur.id = :idActeur');
        $query->execute([':idActeur' => $id]);
        return $query->rowCount() == 1;
    }
}
?>
