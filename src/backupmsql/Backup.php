<?php

use Safebase\dao\DaoAppli;

class Backup
{
    private $db_name;
    private $db_host;
    private $db_pass;
    private $db_user;
    private $db_port;

    public function __construct($db_name = 'task_management', $db_host = 'localhost', $db_pass = 'Postmalone0751@', $db_user = 'root', $db_port = 3306)
    {
        $this->db_name = $db_name;
        $this->db_host = $db_host;
        $this->db_pass = $db_pass;
        $this->db_user = $db_user;
        $this->db_port = $db_port;
    }

    public function delete($id)
    {
        $dao = new DaoAppli();
        $dao->deleteBackup($id);
    }

    public function Backupition($outputFile = 'dummy.sql')
    {
        $output = null;
        $retval = null;

        try {
            $command = "C:\\wamp64\\bin\\mysql\\mysql8.0.31\\bin\\mysql.exe -u root -pPostmalone0751@ -h localhost -P 3306 task_management < dummy.sql";
            var_dump($command);

            exec($command, $output, $retval);
        } catch (Exception $e) {
            var_dump($e);
        }

        if ($retval === 0) {
            echo 'Le backup a été créé avec succès.';
        } else {
            echo "Erreur lors de la création du backup. Code de retour : $retval";
        }

        var_dump($output);
        var_dump($retval);
    }
}
