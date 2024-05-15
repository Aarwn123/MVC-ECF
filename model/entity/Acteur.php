<?php


namespace Model\entity;

class Acteur
{
    private $id;
    private $nom;
    private $prenom;
    private $acteurs = [];

    public function __construct(int $id, string $nom, string $prenom)
    {
        $this->setId($id);
        $this->setNom($nom);
        $this->setPrenom($prenom);
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nom
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get the value of prenom
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set the value of prenom
     *
     * @return  self
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function addActeur(Acteur $acteur)
    {
        $this->acteurs[] = $acteur;
    }

    /**
     * Récupère la liste des acteurs du film
     */
    public function getActeurs(): array
    {
        return $this->acteurs;
    }
}
