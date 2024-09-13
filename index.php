<?php

declare(strict_types=1);

namespace Safebase;

use Safebase\model\Model;
use Safebase\api\tacheCron;
use Safebase\Controller\Backup;
use Safebase\Controller\ClientDB;
use Safebase\Controller\Home;
use Safebase\model\entity\clientDbEntity;

// phpinfo();
// die();
require_once __DIR__ . '/vendor/autoload.php';
require_once('config.php');
/* router de l'application */

//ex: localhost:3000/ressource?niveau=2
$uri = $_SERVER['REQUEST_URI'];
$route = explode('?', $uri)[0];
$method = strtolower($_SERVER['REQUEST_METHOD']);
//separe les segments de l'adresse
$segments = explode('/', trim($route, '/'));
// echo $route . ' - ' . $method;
print_r($segments);
echo ('<br>');
//valeurs en dur pour une DB mysql
// $type = "mysql";
// $host = "localhost";
// $port = "default";
// $db_name = "echangeJeune";
// $db_name = "echangeJeune_dev";
// $username = "root";
// $password = "toto";

// $host = 'localhost';
// $db_name = 'super-reminder';
// $port = 'default';
// $username = 'root';
// $password = 'toto';

//valeurs en dur pour une DB pgsql
$type = 'pgsql';
$host = 'localhost';
// $db_name = 'testpostgressql';
$db_name = 'testpostgressql_dev';
$port = '5432';
$username = 'postgres';
$password = 'toto';

// $cntrl = new CntrlAppli;
// $api = new ClientDB($type, $host, $port, $db_name, $username, $password);
// $cron = new TacheCron;
// $appDB = new Model;

//-----------------------------------------------------------------------------------------------
// if ($method == 'get' and $route == '/') {
//     $cntrl = new Home;
//     $cntrl->getIndex();
//     // } elseif ($method == 'get' and $segments[0] == 'ClientDB') {
//     // $clientDB = new ClientDB($type, $host, $port, $db_name, $username, $password);
//     // $clientDB->test();
// } elseif ($method == 'get' and $segments[0] == 'api') {
//     // Routes vers CRON
//     if (isset($segments[1]) and $segments[1] == 'cron') {
//         echo ('<br>route cron<br>');
//         if (isset($segments[2]) and $segments[2] == 'create') {
//             echo ('create');
//             $cron->createCron();
//         } else if (isset($segments[2]) and $segments[2] == 'delete') {
//             $cron->deleteTask();
//         } else if (isset($segments[2]) and $segments[2] == 'test1') {
//             $taskname = 'test25';
//             $taskSchedule = 'mois';
//             $timeSet = '22:10';
//             $startingDate = '10/10/2024'; //yyyy-mm-dd
//             $scriptPath = 'PC:\wamp64\bin\php\php8.2.18\php.exe';
//             $clientDB_id = '1';
//             $cron = new TacheCron($taskname, $taskSchedule, $timeSet, $startingDate, $scriptPath, $clientDB_id);
//             echo 'route test1 <br>';
//             // $cron->createCron();
//             $cron->deleteTask();
//         }
//     } elseif ($method == 'get' and $segments[1] == 'testconnection') {
//         $api->testConnection();
//     } elseif ($method == 'get' and $segments[1] == 'backup') {
//         $api->createBackup();
//     } elseif ($method == 'get' and $segments[1] == 'restoreDB') {
//         $api->restoreDB();
//     }
//     // route vers index
// } else {
//     $cntrl->getIndex();
// }

if (empty($segments)) {
    $segments[0] = 'home';
}
switch ($segments[0]) {
    case 'home':
        if ($method == 'get') {
            $cntrl = new Home;
            $cntrl->getIndex();
        }
        break;
    case 'ClientDB':
        $clientDBCtrl = new ClientDB;
        switch ($method) {
            case 'get':
                echo 'route get clientDB';
                //trouver une solution pour lancer le test avec les mêmes infos que le formulaire d'enregistrement de clientDB
                $clientDBCtrl->test($type, $host, $port, $db_name, $useType, $username, $password);
                break;
            case 'post':
                $clientDBCtrl->createClientDB();
                break;
            case 'put':
                # code...
                break;
            case 'delete':
                # code...
                break;
            default:
                echo '<h3>cette méthode n\'est pas prise en charge</h3>';
                break;
        }
        break;
    case 'Backup':
        $BackupCtrl = new Backup;
        switch ($method) {
            case 'get':
                $BackupCtrl->displayBackups();
                break;
            case 'post':
                // $BackupCtrl = new Backup;
                $BackupCtrl->createBackup(1);
                echo 'route create';
                break;
            case 'put':
                # code...
                break;
            case 'delete':
                // $BackupCtrl = new Backup;
                $BackupCtrl->delete($segments[1]);
                break;
            default:
                echo '<h3>cette méthode n\'est pas prise en charge</h3>';
                break;
        }
        break;
    case 'CronTask':
        switch ($method) {
            case 'get':

                break;
            case 'post':
                # code...
                break;
            case 'put':
                # code...
                break;
            case 'delete':
                # code...
                break;
            default:
                echo '<h3>cette méthode n\'est pas prise en charge</h3>';
                break;
        }
        break;
    case 'Restore':
        switch ($method) {
            case 'get':

                break;
            case 'post':
                # code...
                break;
            case 'put':
                # code...
                break;
            case 'delete':
                # code...
                break;
            default:
                echo '<h3>cette méthode n\'est pas prise en charge</h3>';
                break;
        }
        break;
    default:
        echo '<h1>route non connue !</h1><h3>la page demandée n\'existe pas</h3>';
        break;
}



// ex de routes API rest
// /user GET
// /user POST
// /user/:id PUT
// /user/:id DELETE