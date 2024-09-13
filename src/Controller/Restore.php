<?php

namespace Safebase\Controller;

class Restore {
    private $dao;
    private $type;
    private $host;
    private $port;
    private $db_name;
    private $username;
    private $password;

    public function __construct()
    {
        //new clientDB
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
