<?php
namespace Safebase\dao;

// echo ('hello');

use \PDO as PDO;

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
        $requete = Requete::INS_DATABASE;
        
        $statement = $this->db->prepare($requete);

        $passwordHash=password_hash($database->getpassword(),PASSWORD_DEFAULT);

        $statement->bindValue(":nom",$database->getname(),PDO::PARAM_STR);
        $statement->bindValue(":password",$passwordHash,PDO::PARAM_STR);
        $statement->bindValue(":port",$database->getport(),PDO::PARAM_STR);
        $statement->bindValue(":url",$database->gethost(),PDO::PARAM_STR);
        $statement->bindValue(":used_type",$database->getusedType(),PDO::PARAM_STR);
        $statement->bindValue(":user" ,$database->getuserName(),PDO::PARAM_STR);
        $statement->bindValue(":type_base",$database->gettype(),PDO::PARAM_INT);
        return $this->tryExecute($statement);
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
        $statement->bindValue(":id",$id,PDO::PARAM_INT);
        return $this->tryExecute($statement);
        
    }

    public function deleteCron($id){
        $statement = $this->db->prepare(Requete::DEL_TASK_CRON);
        $statement->bindValue(":id",$id,PDO::PARAM_INT);
        return $this->tryExecute($statement);
        
    }

    // On essai de se connecter à la base de données
    public function tryConnection($type, $host, $port, $db_name, $username, $password)
    {
        $monErreur = 'Connection réussie ! ';

        if (!isset($this->db)) {
            try {
                $this->db = new PDO($type . ":host=" . $host . ";port=" . $port . ";dbname=" . $db_name, $username, $password);
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->createNewBase($type, $host, $port, $db_name, $username, $password);
            } catch (\PDOException $e) {
                return $e;
            }
        }
        echo ($monErreur);

        return $this->db;
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
        $statement->bindValue(":ID_DATABASE",$cron->getIdDatabase()->getId(),PDO::PARAM_STR);
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
