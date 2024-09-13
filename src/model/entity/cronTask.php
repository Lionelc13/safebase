<?php

namespace Safebase\model\entity;

use Safebase\model\Model;
use \PDO;

class crontask extends Model
{

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
