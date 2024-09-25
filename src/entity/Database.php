<?php

namespace Safebase\entity;

use Safebase\Controller\CntrlAppli;
use Safebase\dao\DaoAppli;

class Database {
    private int $id;
    private string $name;
    private string $password;
    private string $userName;
    private string $port;
    private Type $type;
    private string $host;
    private DaoAppli $dao;
    private string $usedType;

public function __construct( 
        int $id = 0,
        string $name = '',
        string $password = '',
        string $userName = '',
        string $port = '3306',
        Type $type = new Type(1,'mysql'),
        string $usedType = 'prod',
        string $host = 'localhost'
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->password = $password;
        $this->userName = $userName;
        $this->port = $port;
        $this->type = $type;
        $this->usedType = $usedType;
        $this->host = $host;
        $this->dao = new DaoAppli;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

  
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of userName
     *
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }

    
    public function getPort(): string
    {
        return $this->port;
    }

    public function setPort(string $port): self
    {
        $this->port = $port;

        return $this;
    }

    public function getType(): Type
    {
        return $this->type;
    }

    public function setType(Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getUsedType(): string
    {
        return $this->usedType;
    }

    public function setUsedType(string $usedType): self
    {
        $this->usedType = $usedType;

        return $this;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function setHost(string $host): self
    {
        $this->host = $host;
        return $this;
    }

    public function create()
    {
        $type = new Type(1, 'mysql');
        $database = new Database(name: htmlspecialchars($_POST['name']),
            password: htmlspecialchars($_POST['password']),
            userName: htmlspecialchars($_POST['user']),
            port: htmlspecialchars($_POST['port']),
            host: htmlspecialchars($_POST['host']),
            type: $type,
            usedType: 'prod');

        $dao = new DaoAppli;  
        if (($this->dao->createNewBase($database)) == false){
            echo "echec de l'ajout";
            $cntrlAppli = new CntrlAppli();
            $cntrlAppli->getIndex();
        } else {
            header('Location: /database');
        }
    } 
    public function listDatabase():array
    {
        return $this->dao->getListDatabase();
    }
    public function delete($id):string
    {
        if ($this->dao->deleteDatabase($id)){
            return 'Suppression réalisée avec succès!';
        } else 
        return 'echec de la suppression!';
    }
    public function getDataById($id):Database
    {
        return $this->dao->selectDatabaseById($id);
        
    }
}
