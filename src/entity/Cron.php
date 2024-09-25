<?php

namespace Safebase\entity;

use DateTime;
use Safebase\api\testconnection;
use Safebase\dao\DaoAppli;

class Cron
{
    private int $id;
    private ?string $name;
    private ?DateTime $dateStart;
    private ?DateTime $heure;
    private ?string $recurrence;
    private ?Database $database;

    public function __construct(?int $id=1,
        ?string $name ='',
        ?DateTime $dateStart =null,
        ?DateTime $heure=null,
        ?string $recurrence='',
        ?Database $database = new Database())
         {
        $this->id = $id;
        $this->name = $name;
        $this->dateStart = $dateStart;
        $this->heure = $heure;
        $this->recurrence = $recurrence;
        $this->database = $database;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getDateStart(): ?DateTime
    {
        return $this->dateStart;
    }

    public function setDateStart(?DateTime $dateStart): self
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getHeure(): ?DateTime
    {
        return $this->heure;
    }

    public function setHeure(?DateTime $heure): self
    {
        $this->heure = $heure;

        return $this;
    }

    public function getRecurrence(): ?string
    {
        return $this->recurrence;
    }

    public function setRecurrence(?string $recurrence): self
    {
        $this->recurrence = $recurrence;
        return $this;
    }

    public function listCron()
    {
        $dao = new DaoAppli;
        $dao->getListCron();
    } 

    public function deleteCron(int $id)
    {
       $dao = new DaoAppli;
       $dao->deleteCron($id);

    }

    public function create()
    {
        $dao = new DaoAppli;
        // format la date de demarrage
        $dateTime = \DateTime::createFromFormat('Y-m-d', $_POST['datestart']);
        $time = \DateTime::createFromFormat('H:i', $_POST['heure']);
       if ($dateTime and $time) {
            // $this->database->setId($_POST['iddatabase']);
            // $database = new Database();
            $this->database = $this->database->getDataById($_POST['iddatabase']);
            $cron = new Cron(1, $_POST['nom'], $dateTime, $time, $_POST['recurrence'], $this->database);
            if ($dao->createNewTask($cron)) {
        
                $CreateDump = new Testconnection();
                $CreateDump->test($this->database);
                require_once 'cronExec.php';
                }
             else {
                echo ('echec de l enregistrement');
            }
        
        } else {
            echo "La conversion a échoué.";
        }
    }

    private function taskWindows()
    {
        // Chemin complet vers l'exécutable PHP et le script PHP
        $phpPath = 'C:\wamp64\bin\php\php8.2.0\php.exe';
        //$scriptPath = 'C:\wamp64\www\safebase\src\api\cronPHP\job1.php';
        $scriptPath = 'C:\wamp64\www\safeBase\src\api\TestConnection.php';

        // Vérifie si le système d'exploitation est Windows
 

        echo 'Création de la tâche cron sous Windows via PHP...';   

        // Commande pour créer la tâche cron
        $command = "schtasks /create /tn \"testCronPHP\" /tr \"$phpPath $scriptPath\" /sc minute /mo 1";

        // Exécute la commande
        exec($command, $output, $result);
    
    }
    /**
     * Get the value of database
     *
     * @return ?Database
     */
    public function getDatabase(): ?Database
    {
        return $this->database;
    }

    /**
     * Set the value of database
     *
     * @param ?Database $database
     *
     * @return self
     */
    public function setDatabase(?Database $database): self
    {
        $this->database = $database;

        return $this;
    }
}
