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
    private $password;

    function __construct()
    {
        $this->type = htmlspecialchars($_POST['type']);
        $this->host = htmlspecialchars($_POST['host']);
        $this->port = htmlspecialchars($_POST['port']);
        $this->db_name = htmlspecialchars($_POST['db_name']);
        $this->username = htmlspecialchars($_POST['username']);
        $this->password = htmlspecialchars($_POST['password']);
        $this->clientDb = new clientDbEntity($this->type, $this->host, $this->port, $this->db_name, $this->username, $this->password);
    }

    public function test()
    {
        $this->clientDb->getConnection();
        $this->clientDb->testConnection();
    }

    public function createClientDB()
    {
        echo ('<br>createClientDB<br>');
        $this->clientDb->insertDB($this->type, $this->host, $this->port, $this->db_name, $this->username, $this->password);
    }
}
