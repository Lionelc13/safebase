<?php

namespace Safebase\model\entity;

use Safebase\model\Model;
use \PDO;
use \PDOException;

class clientDbEntity extends Model
{
    private $idBD;
    private $type;
    private $host;
    private $port;
    private $db_name;
    private $username;
    private $password;
    private $useType;

    public function __construct($type, $host, $port, $db_name, $username, $useType, $password)
    {
        $this->table = 'client_database';
        $this->getConnection();
        // affecter aux propriétés les données reçues du formulaire d'enregistrement en POST
        $this->type = $type;
        $this->host = $host;
        $this->port = $port;
        $this->db_name = $db_name;
        $this->username = $username;
        $this->useType = $useType;
        $this->password = $password;
    }

    /**
     * test si la connection est possible avec un DB cliente avec les paramètres fournis
     *
     * @return void
     */
    public function testConnection()
    {
        try {
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ];
            $clientDbConnexion = new PDO(
                $this->type . ":host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name,
                $this->username,
                $this->password,
                $options
            );
            // $clientDbConnexion->exec("set names utf8");
            echo ('<br>Client DATABASE connected !<br>');
        } catch (PDOException $exception) {
            throw $exception;
        }
        if (isset($clientDbConnexion)) {
            echo ('CLIENT DATABASE TEST IS OK');
        } else {
            echo ('CLIENT DATABASE TEST IS NOT OK');
        }
    }

    public function insertDB($type, $host, $port, $db_name, $username, $useType, $password)
    {
        // requête d'insert des params de la DBcliente en DB
        echo ('<br>insertClientDB<br>');
        $sql = "INSERT INTO " . $this->table . " (nom, password ,user_database ,url ,port ,used_type, FK_TYPE) VALUES (:nom, :password, :user_database, :url, :port, :used_type, :FK_TYPE)";
        $query = $this->_connexion->prepare($sql);
        $query->bindParam(':nom', $db_name,  PDO::PARAM_STR);
        $query->bindParam(':password', $password,  PDO::PARAM_STR);
        $query->bindParam(':user_database', $username,  PDO::PARAM_STR);
        $query->bindParam(':url', $host,  PDO::PARAM_STR);
        $query->bindParam(':port', $port,  PDO::PARAM_STR);
        $query->bindParam(':used_type', $useType,  PDO::PARAM_STR);
        // le type doit être l'id du type de bd : mysql ou pgsql
        $query->bindParam(':FK_TYPE', $type,  PDO::PARAM_INT);
        $query->execute();
    }
}
