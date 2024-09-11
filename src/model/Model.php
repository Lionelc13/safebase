<?php

namespace Safebase\model;

use \PDO as PDO;
use \PDOException;

class Model
{
    // infos de connexion
    private $host = APP_DBHOST;
    private $db_name = APP_DBNAME;
    private $username = APP_DBUSERNAME;
    private $password = APP_DBPWD;

    // Propriété qui contiendra l'instance de la connexion à la base de donnée
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
        // On essaie de se connecter à la base
        try {
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ];
            $this->_connexion = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password,
                $options
            );
            $this->_connexion->exec("set names utf8");
            echo ('<br>app DATABASE connected !<br>');
        } catch (PDOException $exception) {
            throw $exception;
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
    public function getAll(string $order = "", $limit = ""): array
    {
        $sql = "SELECT * FROM " . $this->table;
        if ($order != "") {
            $sql .= " ORDER BY " . $order;
        }
        if ($limit != "") {
            $sql .= " LIMIT " . $limit;
        }
        $query = $this->_connexion->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function insertCRON($clientDB_id, $taskname, $taskSchedule, $timeSet, $startingDate): void
    {
        echo ('<br>insertion d\'un cron dans la db de l\'application<br>'); {
            // Construction de la requête SQL d'insertion
            $sql = "INSERT INTO " . $this->table . " (nom, recurrence, heure, date_demarrage, FK_DATABASE)";
            $sql .= " VALUES (:taskname, :taskSchedule, :timeSet, :startingDate, :clientDB_id)";

            $query = $this->_connexion->prepare($sql);
            $query->bindParam(':taskname', $taskname,  PDO::PARAM_STR);
            $query->bindParam(':taskSchedule', $taskSchedule,  PDO::PARAM_STR);
            $query->bindParam(':timeSet', $timeSet,  PDO::PARAM_STR);
            $query->bindParam(':startingDate', $startingDate,  PDO::PARAM_STR);
            $query->bindParam(':clientDB_id', $clientDB_id,  PDO::PARAM_INT);
            $query->execute();
            echo ($sql);
        }
    }
}
