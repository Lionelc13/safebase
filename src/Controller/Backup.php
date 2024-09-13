<?php

namespace Safebase\Controller;

use Safebase\model\entity\backup as EntityBackup;
use Safebase\model\entity\clientDbEntity;

class Backup
{
    private $entity;
    private $backupId;
    private $dbId;
    private $version;


    public function __construct() {}

    // get all Backups
    public function displayBackups()
    {
        // requête Select * table Backup 
        $entity = new EntityBackup;
        $result = $entity->getAll();

        // envoyer à la vue les données à afficher
        var_dump($result);
    }

    public function delete($id)
    {
        // requête Select * table Backup 
        $this->entity = new EntityBackup;
        $this->entity->deleteBackup($id);
        echo '<br>ligne supprimée avec succès</br>';
    }

    // create backup $bdId à récupérer dans le formulaire
    public function createBackup($dbId)
    {
        $type = $_POST['type'];
        $host = $_POST['host'];
        $port = $_POST['port'];
        $db_name = $_POST['db_name'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        if ($port == 'default') {
            if ($type == 'mysql') {
                $port = '3306';
            } else {
                $port = '5432';
            }
        }

        echo ('<pre>');
        var_dump($_REQUEST);
        $root_path = $_SERVER['DOCUMENT_ROOT'];
        //vérifier si un dossier de dumps est déjà créé pour cette DB, sinon le créer
        $directory = $root_path . DIRECTORY_SEPARATOR . 'dumps' . DIRECTORY_SEPARATOR  . $db_name;
        if (file_exists($directory)) {
            echo ("'Le dossier '.$directory.' existe.<br>'");
        } else {
            echo ("'Le dossier '.$directory.' n'existe pas.<br>'");
            mkdir($directory);
            echo ("Le dossier '.$directory.' a été créé. ");
        }

        $date = date("Y-m-d_H-i-s");
        $dump_name = $db_name . '_' . $date . '.sql';
        $root_path = $_SERVER['DOCUMENT_ROOT'];
        $ExportPath = $root_path . DIRECTORY_SEPARATOR . 'dumps' . DIRECTORY_SEPARATOR  . $db_name . DIRECTORY_SEPARATOR . $dump_name;
        // comande CLI pour la création d'un backup soit en mysql soit en pgsql
        if ($type == 'mysql') {
            $command = 'mysqldump --opt --port=' . $port . ' -h ' . $host . ' -u ' . $username . ' -p' . $password . ' ' . $db_name . ' > "' . $ExportPath . '" 2>&1';
        } elseif ($type == 'pgsql') {
            $command = 'set PGPASSWORD=' . $password . '&& pg_dump -U ' . $username . ' -h ' . $host . ' -p' . $port . ' ' . $db_name . ' > ' . $ExportPath . ' 2>&1';
        }

        exec($command, $output, $result);
        echo ('<hr>' . $command);
        // echo "Code de résultat : " . $result . PHP_EOL;
        // echo "Sortie de la commande (output) : " . PHP_EOL;
        // var_dump($output);
        // echo ('</pre>');

        switch ($result) {
            case 0:
                echo 'La base de données <b>' . $db_name . '</b> a été sauvegardée avec succès dans le chemin suivant : ' . getcwd() . '/' . $ExportPath;
                // insertion dans la table backup en DB
                $this->entity = new EntityBackup;
                $this->entity->insertBackup($dump_name, $dbId);
                break;
            case 1:
                echo '<br> Une erreur s\'est produite lors de l\'exportation de <b>' . $db_name . '</b> vers ' . getcwd() . '/' . $ExportPath;
                echo ('<hr>');
                var_dump($output);
                // écrire ici dans le journal d'alerte failDBdump
                // requête de  type insert dans la table journal_alert
                break;
            default:
                echo 'Une erreur d\'exportation s\'est produite, veuillez vérifier les informations de connexion.';
        }
    }
}
