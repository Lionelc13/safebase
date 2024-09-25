<?php
namespace Safebase\api;

use Safebase\dao\DaoAppli;

class TestConnection
{
    public function test($database):bool
    {
        $type='mysql';
        $dao = new DaoAppli;
        if ($database->getPort() == 'default') {
            if ($database->getType()->getName() == 'mysql') {
                $database->setPort('3306');
            } else {
                $database->setPort('5432');
            }
        }
        $dao->tryConnection($database);
        $db_name = $database ->getName();
        $port = $database->getPort();
        $host = $database->getHost();
        $username = $database->getUserName();
        $password = $database->getPassword();

        
        $date = date("Y-m-d_H-i-s");
        $dump_name = $db_name . '_' . $date . '.sql';
        $root_path = $_SERVER['DOCUMENT_ROOT'];
        $ExportPath = $root_path . DIRECTORY_SEPARATOR . 'dumps' . DIRECTORY_SEPARATOR  . $db_name . DIRECTORY_SEPARATOR . $dump_name;

        //vérifier si un dossier de dumps est déjà créé pour cette DB, sinon le créer
        $directory = $root_path . DIRECTORY_SEPARATOR . 'dumps' . DIRECTORY_SEPARATOR  . $db_name;
        if (file_exists($directory)) {
            echo ("'Le dossier '.$directory.' existe.<br>'");
        } else {
            echo ("'Le dossier '.$directory.' n'existe pas.<br>'");
            mkdir($directory);
            echo ("Le dossier '.$directory.' a été créé. ");
        }
        if ($type == 'mysql') {
            // mysqldump --opt --single-transaction -h localhost -u root -ptoto super-reminder > "C:\\wamp64\\www\\laplateforme\\safebase-1\\dumps"
            $commande = 'mysqldump --opt --port=' . $port . ' -h ' . $host . ' -u ' . $username . ' -p' . $password . ' ' . $db_name . ' > "' . $ExportPath . '"';
        }
        if ($type == 'pgsql') {
            // pg_dump -U utilisateur -h hôte -p port nom_de_la_base > fichier_de_dump.sql
            $commande = 'set PGPASSWORD=toto&& pg_dump -U ' . $username . ' -h ' . $host . ' -p' . $port . ' ' . $db_name . ' > ' . $ExportPath . '';
        }
        echo ('type');
        echo $type;
        echo('<BR>');
        echo ('commande');
        echo $commande;
        
        exec($commande, $output, $result);
        echo ('<hr><pre>');
        echo "Code de résultat : " . $result . PHP_EOL;
        echo "Sortie de la commande (output) : " . PHP_EOL;
        // var_dump($output);
        echo ('</pre>');

        switch ($result) {
            case 0:
                echo 'La base de données <b>' . $db_name . '</b> a été sauvegardée avec succès dans le chemin suivant : ' . getcwd() . '/' . $ExportPath;
                $isOk = true;
                $dao->createBackup($database->getId(),$dump_name);
                break;
            case 1:
                $isOk=false;
                echo 'Une erreur s\'est produite lors de l\'exportation de <b>' . $db_name . '</b> vers ' . getcwd() . '/' . $ExportPath;
                break;
            default:
                $isOk=false;
                echo 'Une erreur d\'exportation s\'est produite, veuillez vérifier les informations de connexion.';
        }


        // echo ('<hr><pre>');
        // var_dump($GLOBALS);
        // echo ('</pre>');
        return $isOk;
    }
}
