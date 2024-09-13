<?php

namespace Safebase\model\entity;

use Safebase\model\Model;
use \PDO;
use \PDOException;

class clientDbEntity extends Model
{
    private $id;
    private $type;
    private $host;
    private $port;
    private $db_name;
    private $username;
    private $password;
    private $used_type;

    public function __construct($type, $host, $port, $db_name, $username, $password)
    {
        $this->table = 'client_database';
        $this->getConnection();
        // affecter aux propriétés les données reçues du formulaire d'enregistrement en POST
        $this->type = $type;
        $this->host = $host;
        $this->port = $port;
        $this->db_name = $db_name;
        $this->username = $username;
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

    public function insertDB($type, $host, $port, $db_name, $username, $password)
    {
        // requête d'insert des params de la DBcliente en DB
        echo ('<br>insertClientDB<br>');
    }
}
