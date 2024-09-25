<?php
namespace Safebase\dumpationgres;

class Restore
{
    private $db_name;
    private $db_host;
    private $db_pass;
    private $db_user;
    private $db_port;
    // mysql://user:userpassword@localhost:3307/safe_base
    public function __construct($db_name = 'basepostgres', $db_host = 'localhost', $db_pass = 'Postmalone0751@', $db_user = 'postgres', $db_port = 5432)
    {
        $this->db_name = $db_name;
        $this->db_host = $db_host;
        $this->db_pass = $db_pass;
        $this->db_user = $db_user;
        $this->db_port = $db_port;
    }

    public function Restor($outputFile = 'file.sql')
    {
        $output = [];
        $retval = null;

        try {
            $command = sprintf(
                'set PGPASSWORD=%s&& C:\\wamp64\\bin\\PostgreSQL\\16\\bin\\psql.exe -h %s -p %d -U %s -d %s -f %s',
                $this->db_pass,
                $this->db_host,
                $this->db_port,
                $this->db_user,
                $this->db_name,
                $outputFile
            );

            // Exécuter la commande
            exec($command, $output, $retval);
        } catch (\Exception $e) {
            var_dump($e);
        }

        if ($retval === 0) {
            echo 'Le restauration a été créé avec succès.'; // 201
        } else {
            echo "Erreur lors de la création de la retauration. Code de retour : $retval"; //403
        }

        // Afficher la sortie de la commande
        foreach ($output as $line) {
            echo $line . PHP_EOL;
        }
    }

    
}
