<?php

namespace Safebase\model;

use \PDO as PDO;
use \PDOException;

abstract class Model
{
    // infos de connexion à la DB de l'appli
    private $type = 'mysql';
    private $port = '3306';
    private $host = APP_DBHOST;
    private $db_name = APP_DBNAME;
    private $username = APP_DBUSERNAME;
    private $password = APP_DBPWD;

    // Propriété qui contiendra l'instance de la connexion à la base de données
    protected ?PDO $_connexion;
    public $table;
    public array $id;

    public function __construct()
    {
        $this->getConnection();
    }

    /**
     * Prépare et valorise la connexion à la base de données de l'application
     *
     * @return void
     */
    public function getConnection(): void
    {
        // On supprime la connexion précédente
        $this->_connexion = null;
        try {
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ];
            $this->_connexion = new PDO($this->type . ":host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name, $this->username, $this->password, $options);
            $this->_connexion->exec("set names utf8");
            echo ('<br>app DATABASE connected !<br>');
        } catch (PDOException $exception) {
            echo "Erreur de connexion à la base de données : " . $exception->getMessage();
        }
    }

    /**
     * Méthode permettant d'obtenir un enregistrement de la table choisie en fonction d'un id
     *
     * @return void
     */
    public function getOne(): mixed
    {
        // Constitution des conditions de recherche de la clé primaire (pouvant être composée)
        $cle_recherchee = "";
        $tab_cles = array();
        foreach ($this->id as $key => $value) {
            $tab_cles[] = $key . "=" . $value; //id_primaryKey = value
        }
        $cle_recherchee = implode(" AND ",  $tab_cles); //pour les clés composées on les concatène avec l'instruction AND

        // Mise en forme de la requete
        //$sql = "SELECT * FROM ".$this->table." WHERE id=".$this->id;
        $sql = "SELECT * FROM " . $this->table . " WHERE " . $cle_recherchee;
        $query = $this->_connexion->prepare($sql);
        $query->execute();
        return $query->fetch();
    }

    /**
     * Méthode permettant d'obtenir tous les enregistrements de la table choisie
     *
     * @param string $order
     * @param string $limit
     * @return array
     */
    public function getAll(string $order = "", $limit = "")
    {
        if (!$this->_connexion) {
            throw new \RuntimeException("La connexion à la base de données n'est pas établie.");
        }

        $sql = "SELECT * FROM " . $this->table;
        if ($order != "") {
            $sql .= " ORDER BY " . $order;
        }
        if ($limit != "") {
            $sql .= " LIMIT " . $limit;
        }
        echo ($sql);
        $query = $this->_connexion->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
}
