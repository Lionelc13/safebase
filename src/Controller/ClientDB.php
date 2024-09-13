<?php

namespace Safebase\Controller;

use Safebase\dao\DaoAppli;
use Safebase\api\TacheCron;
use Safebase\model\entity\clientDbEntity;

class ClientDB
{
    private $clientDb;
    private $type;
    private $host;
    private $port;
    private $db_name;
    private $username;
    private $useType;
    private $password;

    function __construct() {}

    public function test($type, $host, $port, $db_name, $username, $useType, $password)
    {
        $this->clientDb = new clientDbEntity($type, $host, $port, $db_name, $username, $useType, $password);
        $this->clientDb->getConnection();
        $this->clientDb->testConnection();
    }

    public function createClientDB()
    {
        $this->type = htmlspecialchars($_POST['type']);
        $this->host = htmlspecialchars($_POST['host']);
        $this->port = htmlspecialchars($_POST['port']);
        $this->db_name = htmlspecialchars($_POST['db_name']);
        $this->username = htmlspecialchars($_POST['username']);
        $this->useType = htmlspecialchars($_POST['used_type']);
        $this->password = htmlspecialchars($_POST['password']);
        $this->clientDb = new clientDbEntity($this->type, $this->host, $this->port, $this->db_name, $this->username, $this->useType, $this->password);
        echo ('<br>createClientDB<br>');
        $this->clientDb->insertDB($this->type, $this->host, $this->port, $this->db_name, $this->username, $this->useType, $this->password);
    }
}
