<?php

namespace Safebase\api;

use Safebase\dao\DaoAppli;

class ClientDB
{
    private $dao;
    private $type;
    private $host;
    private $port;
    private $db_name;
    private $username;
    private $password;

    function __construct($type, $host, $port, $db_name, $username, $password)
    {
        //set les propriétés de l'objet de la classe
        $this->type = $type;
        $this->host = $host;
        $this->port = $port;
        if ($this->port == 'default') {
            if ($this->type == 'mysql') {
                $this->port = '3306';
            } else {
                $this->port = '5432';
            }
        }
        $this->db_name = $db_name;
        $this->username = $username;
        $this->password = $password;
        $this->dao = new DaoAppli;
        $this->dao->tryConnection($this->type, $this->host, $this->port, $this->db_name, $this->username, $this->password);
    }

    public function testConnection()
    {
        if (isset($this->dao)) {
            echo ('DATABASE TEST OK');
        } else {
            echo ('DATABASE TEST NOT OK');
        }
    }

    // public function createCRON() {}

    public function createBackup()
    {
        $this->dao = new DaoAppli;

        $root_path = $_SERVER['DOCUMENT_ROOT'];
        //vérifier si un dossier de dumps est déjà créé pour cette DB, sinon le créer
        $directory = $root_path . DIRECTORY_SEPARATOR . 'dumps' . DIRECTORY_SEPARATOR  . $this->db_name;
        if (file_exists($directory)) {
            echo ("'Le dossier '.$directory.' existe.<br>'");
        } else {
            echo ("'Le dossier '.$directory.' n'existe pas.<br>'");
            mkdir($directory);
            echo ("Le dossier '.$directory.' a été créé. ");
        }
        $this->backupExec();
    }

    private function backupExec()
    {
        $date = date("Y-m-d_H-i-s");
        $dump_name = $this->db_name . '_' . $date . '.sql';
        $root_path = $_SERVER['DOCUMENT_ROOT'];
        $ExportPath = $root_path . DIRECTORY_SEPARATOR . 'dumps' . DIRECTORY_SEPARATOR  . $this->db_name . DIRECTORY_SEPARATOR . $dump_name;
        // comande CLI pour la création d'un backup soit en mysql soit en pgsql
        if ($this->type == 'mysql') {
            // mysqldump --opt --single-transaction -h localhost -u root -ptoto super-reminder > "C:\\wamp64\\www\\laplateforme\\safebase-1\\dumps"
            $command = 'mysqldump --opt --port=' . $this->port . ' -h ' . $this->host . ' -u ' . $this->username . ' -p' . $this->password . ' ' . $this->db_name . ' > "' . $ExportPath . '"';
        } elseif ($this->type == 'pgsql') {
            // pg_dump -U utilisateur -h hôte -p port nom_de_la_base > fichier_de_dump.sql
            $command = 'set PGPASSWORD=' . $this->password . '&& pg_dump -U ' . $this->username . ' -h ' . $this->host . ' -p' . $this->port . ' ' . $this->db_name . ' > ' . $ExportPath . '';
        }

        exec($command, $output, $result);
        // echo ('<hr><pre>');
        // echo "Code de résultat : " . $result . PHP_EOL;
        // echo "Sortie de la commande (output) : " . PHP_EOL;
        // var_dump($output);
        // echo ('</pre>');

        switch ($result) {
            case 0:
                echo 'La base de données <b>' . $this->db_name . '</b> a été sauvegardée avec succès dans le chemin suivant : ' . getcwd() . '/' . $ExportPath;
                break;
            case 1:
                echo 'Une erreur s\'est produite lors de l\'exportation de <b>' . $this->db_name . '</b> vers ' . getcwd() . '/' . $ExportPath;
                //écrire ici dans le journal d'alerte failDBdump
                break;
            default:
                echo 'Une erreur d\'exportation s\'est produite, veuillez vérifier les informations de connexion.';
        }
    }

    // requête en appDB des Databases enregistrées par le user
    // sélection de la DB à restore
    // rechercher les fichiers stocké en appDB de cette clientDB
    // ===>> requête GETallDumps de la DB en appDB
    // choix du fichier à restore & choix/création de la DB cible par le user et validation 
    // sélection de l'emplacement de la DB pour le load/restore 
    public function restoreDB()
    {
        // getFileName
        $filePath = 'C:\wamp64\www\laplateforme\safebase-1\dumps\testpostgressql\testpostgressql_2024-09-09_13-31-23.sql';
        // $filePath = 'C:\wamp64\www\laplateforme\safebase-1\dumps\super-reminder\super-reminder_2024-09-09_09-52-24.sql';
        // $filePath = 'C:\wamp64\www\laplateforme\safebase-1\dumps\echangeJeune\echangeJeune_2024-09-09_10-54-56.sql';
        $this->restoreExec($filePath);
    }

    private function restoreExec($filePath)
    {
        // $dump_name = $filePath;
        // $root_path = $_SERVER['DOCUMENT_ROOT'];
        // $filePath = $root_path . DIRECTORY_SEPARATOR . 'dumps' . DIRECTORY_SEPARATOR  . $this->db_name . DIRECTORY_SEPARATOR . $dump_name;
        echo ($filePath . '<br>');
        // commande CLI pour la restauration d'un backup soit en mysql soit en pgsql
        if ($this->type == 'mysql') {
            $command = 'mysql -u ' . $this->username . ' -p' . $this->password . ' -h ' . $this->host . ' -P ' . $this->port . ' ' . $this->db_name . ' < "' . $filePath . '"';
        } elseif ($this->type == 'pgsql') {
            $command = 'set PGPASSWORD=' . $this->password . '&& psql -h ' . $this->host . ' -p ' . $this->port . ' -U ' . $this->username . ' -d ' . $this->db_name . ' -f "' . $filePath . '"';
        }
        echo ($command . '<br>');
        exec($command, $output, $result);
        // echo ('<hr><pre>');
        // echo "Code de résultat : " . $result . PHP_EOL;
        // echo "Sortie de la command (output) : " . PHP_EOL;
        // var_dump($output);
        // echo ('</pre>');

        switch ($result) {
            case 0:
                echo 'Le fichier de sauvegarde <b>' . $filePath . '</b> à été appliqué avec succès sur la base de données <b>' . $this->db_name . '</b>';
                break;
            case 1:
                echo 'Une erreur s\'est produite lors de l\'application du fichier de suavegarde <b>' . $filePath . '</b> sur la base de données <b>' . $this->db_name . '</b>';
                var_dump($output);
                break;
            default:
                echo 'Une erreur de chargement de la sauvegarde s\'est produite, veuillez vérifier les informations de connexion.';
        }
    }
}
