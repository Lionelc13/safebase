<?php

namespace Safebase\Controller;

use DateTime;
use Safebase\model\Model;
use Safebase\model\entity\cronTask as c;

class CronTask
{
    private $taskname; // nom de la tâche récurrente
    private $taskSchedule; // récurrence de la tâche, une seule fois ou /jour, /semaine ou /mois 
    private $timeSet; // heure à laquelle se déclenche la tâche  HH-MM-SS
    private $startingDate; // date de démarrage de la tâche YYYY-MM--DD
    private $phpPath = PHP_PATH; // emplacement de php.exe sur le serveur
    private $scriptPath; // path vers le script à lancer lors du déclenchement
    private $clientDB_id; // base de données concernée

    public function __construct($taskname, $taskSchedule, $timeSet, $startingDate, $scriptPath, $clientDB_id)
    {
        $this->taskname = $taskname;
        $this->taskSchedule = $taskSchedule;
        $this->timeSet = $timeSet;
        $this->startingDate = $startingDate;
        $this->scriptPath = $scriptPath;
        $this->clientDB_id = $clientDB_id;
    }

    public function createCron()
    {
        if (PHP_OS === "WINNT") {
            //déterminer le type de planification pour le paramètre "/sc" de la commande shell d'après la valeur de  $this->schedule
            switch ($this->taskSchedule) {
                case 'jour':
                    $sc = 'DAILY';
                    break;
                case 'mois':
                    $sc = 'MONTHLY';
                    break;
                case 'semaine':
                    $sc = 'WEEKLY';
                    break;
                default:
                    $sc = '';
                    break;
            }
            // Création de la tâche dans le planificateur de tâches Windows via PHP
            $command = "schtasks /create /tn \"{$this->taskname}\" /tr \"{$this->phpPath} {$this->scriptPath}\" /sc {$sc} /sd {$this->startingDate} /st {$this->timeSet}";
            $this->execCmd($command);
            $this->DBaddTask();
        } elseif (PHP_OS === "Linux") {
            //déterminer le paramétrage de la commande CRON : * * * * * (minute heure jour_mois mois jour_semaine commande) d'après la valeur de  $this->schedule
            switch ($this->taskSchedule) {
                case 'jour':
                    $sch = '* * *';
                    break;
                case 'mois':
                    $sch = '1 * *';
                    break;
                case 'semaine':
                    $sch = '* * 0';
                    break;
                default:
                    $sch = '';
                    break;
            }
            $time = explode(':', $this->timeSet);
            // Création de la tâche cron sous Linux via PHP
            $cronJob = "{$time[1]} {$time[0]} {$sch} " . escapeshellcmd($this->phpPath) . ' ' . escapeshellarg($this->scriptPath);
            $this->addCronJob($cronJob);
        } else {
            echo 'Le script doit être exécuté sous Windows ou Linux.';
        }
    }

    public function deleteTask()
    {
        if (PHP_OS === "WINNT") {
            // Suppression de la tâche taskmanager sous Windows via PHP
            $command = "schtasks /delete /tn \"{$this->taskname}\" /f";
            $this->execCmd($command);
        } elseif (PHP_OS === "Linux") {
            // Suppression de la tâche cron sous Linux via PHP
            $this->removeCronJob($this->taskname);
        }
    }

    private function addCronJob($cronJob)
    {
        // Lire la crontab actuelle
        exec('crontab -l 2>/dev/null', $output, $result);

        // Ajouter la nouvelle tâche cron
        $currentCrontab = implode("\n", $output);
        $newCrontab = $currentCrontab . "\n" . $cronJob;

        // Écrire la nouvelle crontab
        $tmpFile = '/tmp/my_crontab';
        file_put_contents($tmpFile, $newCrontab);
        exec('crontab ' . escapeshellarg($tmpFile), $output, $result);

        // Supprimer le fichier temporaire
        unlink($tmpFile);

        // Vérifier si la tâche a été ajoutée avec succès
        if ($result === 0) {
            echo 'La tâche est planifiée avec succès.';
            $this->DBaddTask();
        } else {
            echo 'Une erreur est survenue lors de l\'exécution de la commande de planification';
        }
    }

    private function removeCronJob($taskname)
    {
        // Lire la crontab actuelle
        exec('crontab -l 2>/dev/null', $output, $result);

        // Supprimer la tâche spécifique
        $currentCrontab = implode("\n", $output);
        $lines = explode("\n", $currentCrontab);
        $newCrontab = '';
        foreach ($lines as $line) {
            if (!strpos($line, $taskname)) {
                $newCrontab .= $line . "\n";
            }
        }

        // Écrire la nouvelle crontab
        $tmpFile = '/tmp/my_crontab';
        file_put_contents($tmpFile, $newCrontab);
        exec('crontab ' . escapeshellarg($tmpFile), $output, $result);

        // Supprimer le fichier temporaire
        unlink($tmpFile);

        // Vérifier si la tâche a été supprimée avec succès
        if ($result === 0) {
            echo 'La tâche a été supprimée avec succès.';
        } else {
            echo 'Une erreur est survenue lors de la suppression de la tâche';
        }
    }

    private function execCmd($command)
    {
        //TODO ne prend pass 2x le même nom de tâche
        $command .= ' 2>&1';
        echo ('<br>' . $command . '<br>');
        exec($command, $output, $result);
        if ($result === 0) {
            if (strpos($command, 'create')) {
                echo 'La tâche est planifiée avec succès.';
            } elseif (strpos($command, 'delete')) {
                echo 'La tâche est supprimée avec succès.';
            }
        } else {
            echo 'Une erreur est survenue lors de l\'exécution de la commande de planification';
            var_dump($output);
        }
    }

    private function DBaddTask()
    {
        $startDate = DateTime::createFromFormat('d/m/Y', $this->startingDate);
        $startDate = $startDate->format('Y-m-d');
        $DBapp = new c;
        $DBapp->table = 'tache_cron';
        $DBapp->insertCRON($this->clientDB_id, $this->taskname, $this->taskSchedule, $this->timeSet, $startDate);
    }
}
