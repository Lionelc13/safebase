<?php
namespace Safebase\dao;

// echo ('hello');

use \PDO as PDO;
use Safebase\entity\Database;
use Safebase\entity\Type;

//require_once 'src/controller/Utilitaire.php';
class DaoAppli
{
    protected PDO $db;
    public function __construct(){
         $this->db = $this->getConnection();
    }
    //On essai de se connecter à la base de données
    public function getConnection() {
        $host       = "localhost";
        $db_name    = "safebase";
        $username   = "root";
        $password   = "Postmalone0751@";

        if (!isset($this->db)) {
            try {
                $this->db = new PDO("mysql:host=".$host.";charset=utf8;dbname=".$db_name, $username, $password);
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e) {
                    echo('Echec de la connexion: ' . $e->getMessage());
                die();
            }
        }
        return $this->db;
    }

    public function createNewBase($database): bool
    { 
        $connected = $this->tryConnection($database); 
        var_dump($connected);
        if ($connected){
            $requete = Requete::INS_DATABASE;
            
            $statement = $this->db->prepare($requete);

            //$passwordHash=password_hash($database->getpassword(),PASSWORD_DEFAULT);

            $statement->bindValue(":nom",$database->getName(),PDO::PARAM_STR);
            $statement->bindValue(":password",$database->getPassword(),PDO::PARAM_STR);
            $statement->bindValue(":port",$database->getPort(),PDO::PARAM_STR);
            $statement->bindValue(":url",$database->getHost(),PDO::PARAM_STR);
            $statement->bindValue(":used_type",$database->getusedType(),PDO::PARAM_STR);
            $statement->bindValue(":user" ,$database->getUserName(),PDO::PARAM_STR);
            $statement->bindValue(":type_base",$database->getType()->getId(),PDO::PARAM_INT);
            
           return $this->tryExecute($statement);
        } else {
            
            return false;
        }
        
        //On essaie d'ajouter une nouvelle base
        // try {
        //     $statement->execute();
        //     $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //     return true;
        // }
        // catch (\PDOException $e) {
        //     return $e->getMessage();
        // }
    }

    

    public function getListDatabase():array{
        $requete = Requete::SEL_CLIENT_DATABASE;
        $statement = $this->db->query($requete); 
        $data=$statement->fetchAll();
        return $data;
        
    }

    public function getListCron(){
        $statement = $this->db->query(Requete::SEL_CRON); 
        $data=$statement->fetchAll();
        return $data;
        
    }
    
    public function getListBackup(){
        $statement = $this->db->query(Requete::SEL_BACKUP); 
        $data=$statement->fetchAll();
        return $data;
        
    }



    public function deleteDatabase($id){
        
        $statement = $this->db->prepare(Requete::DEL_CLIENT_DATABASE);
        $statement->bindValue(":id",intval($id),PDO::PARAM_INT);
        return $this->tryExecute($statement);
        
    }

    public function selectDatabaseById($id){
        $statement = $this->db->prepare(Requete::SEL_DB_BY_ID);
        $statement->bindValue(":id",$id,PDO::PARAM_INT);
        $statement->execute();
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        $type= new Type($data['id_type'], $data['name_type']);
        $data= new Database($id,
                             $data['nom'],
                            $data['password'],
                            $data['user_database'],
                            $data['port'],
                            $type,
                            $data['used_type'],
                            $data['url']

                        );
        return $data;
        
    }

    public function deleteCron($id){
        $statement = $this->db->prepare(Requete::DEL_TASK_CRON);
        $statement->bindValue(":id",$id,PDO::PARAM_INT);
        return $this->tryExecute($statement);
        
    }

    public function deleteBackup($id){
        $statement = $this->db->prepare(Requete::DEL_BACKUP);
        $statement->bindValue(":id",$id,PDO::PARAM_INT);
        return $this->tryExecute($statement);
        
    }

    public function createBackup($id, $version)
    {
        $statement = $this->db->prepare(Requete::INS_BACKUP);
        var_dump('id: ' . $id .' version: ' . $version);
               $statement->bindValue(":id",$id,PDO::PARAM_INT);
        $statement->bindValue(":version",$version,PDO::PARAM_STR);
        return $this->tryExecute($statement);
    }


    // On essai de se connecter à la base de données
    //public function tryConnection($type, $host, $port, $db_name, $username, $password)
    public function tryConnection($database):bool
    {
    
        // if (isset($this->db)) {
            try {
                $connected = new PDO($database->getType()->getName() . ":host=" . $database->getHost() . ";port=" . $database->getPort() . ";dbname=" . $database->getName(), $database->getUserName(), $database->getPassword());
                $connected->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return true;
            } catch (\PDOException $e) {
               return false;
            }
        //}
    }


    public function createNewTask($cron): bool
    {   
        $requete = Requete::INS_CRON;
        
        $statement = $this->db->prepare($requete);
        
        $dateString= date_format($cron->getDateStart(),'Y-m-d');
        $timeString = date_format($cron->getHeure(),'H:i');
        $statement->bindValue(":nom",$cron->getName(),PDO::PARAM_STR);
        $statement->bindValue(":recurrence",$cron->getRecurrence(),PDO::PARAM_STR);
        $statement->bindValue(":date_demarrage",$dateString,PDO::PARAM_STR);
        $statement->bindValue(":heure",$timeString,PDO::PARAM_STR);
        $statement->bindValue(":ID_DATABASE",$cron->getDatabase()->getId(),PDO::PARAM_STR);
        //On essaie d'ajouter une nouvelle base
        try {
            $statement->execute();
            echo('creation de la base de données');
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return true;
        }
        catch (\PDOException $e) {
            
            return $e->getMessage();
        }
    }
    public function tryExecute($statement){
        try {
            $statement->execute();
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return true;
        }
        catch (\PDOException $e) {
            return false;
        }
    }
}
