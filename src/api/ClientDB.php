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

    public function createBackup()
    {
        $this->dao = new DaoAppli;
        if ($this->port == 'default') {
            if ($this->type == 'mysql') {
                $this->port = '3306';
            } else {
                $this->port = '5432';
            }
        }

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

    public function backupExec()
    {
        $date = date("Y-m-d_H-i-s");
        $dump_name = $this->db_name . '_' . $date . '.sql';
        $root_path = $_SERVER['DOCUMENT_ROOT'];
        $ExportPath = $root_path . DIRECTORY_SEPARATOR . 'dumps' . DIRECTORY_SEPARATOR  . $this->db_name . DIRECTORY_SEPARATOR . $dump_name;
        // comande CLI pour la création d'un backup soit en mysql soit en pgsql
        if ($this->type == 'mysql') {
            // mysqldump --opt --single-transaction -h localhost -u root -ptoto super-reminder > "C:\\wamp64\\www\\laplateforme\\safebase-1\\dumps"
            $commande = 'mysqldump --opt --port=' . $this->port . ' -h ' . $this->host . ' -u ' . $this->username . ' -p' . $this->password . ' ' . $this->db_name . ' > "' . $ExportPath . '"';
        }
        if ($this->type == 'pgsql') {
            // pg_dump -U utilisateur -h hôte -p port nom_de_la_base > fichier_de_dump.sql
            $commande = 'set PGPASSWORD=' . $this->password . '&& pg_dump -U ' . $this->username . ' -h ' . $this->host . ' -p' . $this->port . ' ' . $this->db_name . ' > ' . $ExportPath . '';
        }

        exec($commande, $output, $result);
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
                break;
            default:
                echo 'Une erreur d\'exportation s\'est produite, veuillez vérifier les informations de connexion.';
        }
    }
}
