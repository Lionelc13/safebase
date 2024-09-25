<?php

class Dump
{
    private $db_name;
    private $db_host;
    private $db_pass;
    private $db_user;
    private $db_port;

    public function __construct($db_name = 'basepostgres', $db_host = 'localhost', $db_pass = 'Postmalone0751@', $db_user = 'postgres', $db_port = 5432)
    {
        $this->db_name = $db_name;
        $this->db_host = $db_host;
        $this->db_pass = $db_pass;
        $this->db_user = $db_user;
        $this->db_port = $db_port;
        $this->Dumpition();
    }

    public function Dumpition()
    {
        $output = [];
        $retval = null;

        try {
            // Préparer la commande
            //$command = 'set PGPASSWORD=Postmalone0751@ C:\\wamp64\\bin\\PostgreSQL\\16\\bin\\pg_dump.exe -h localhost -U postgres -p 5432 basepostgres > dummaa.sql 2>&1';
            $command = 'set PGPASSWORD=Postmalone0751@&& C:\\wamp64\\bin\\PostgreSQL\\16\\bin\\pg_dump.exe --no-owner -h localhost -p 5432 -U postgres basepostgres > file.sql';
            // Debugging : affiche la commande
            var_dump($command);

            // Exécuter la commande
            exec($command, $output, $retval);
        } catch (Exception $e) {
            var_dump($e);
        }

        if ($retval === 0) {
            echo 'Le dump a été créé avec succès.';
        } else {
            echo "Erreur lors de la création du dump. Code de retour : $retval";
        }

        // Afficher la sortie de la commande
        foreach ($output as $line) {
            echo $line . PHP_EOL;
        }
    }
}

