<?php

namespace Safebase\model\entity;

use Safebase\model\Model;
use \PDO;
use \PDOException;

class backup extends Model
{
    public function __construct()
    {
        $this->table = 'backup';
        $this->getConnection();
    }

    //create backup
    public function insertBackup($dump_name, $dbId)
    {
        $sql = "INSERT INTO " . $this->table . " (version, FK_DATABASE) VALUES (:dump_name, :dbId)";
        $query = $this->_connexion->prepare($sql);
        $query->bindParam(':dump_name', $dump_name,  PDO::PARAM_STR);
        $query->bindParam(':dbId', $dbId,  PDO::PARAM_INT);
        $query->execute();
    }



    //effacer un backup via son id
    public function deleteBackup($id)
    {
        $sql = "DELETE FROM " . $this->table . " WHERE id = " . $id;
        $query = $this->_connexion->prepare($sql);
        $query->execute();
    }
}
