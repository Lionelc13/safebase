<?php

declare(strict_types=1);

namespace Safebase;

use Safebase\model\Model;
use Safebase\api\tacheCron;
use Safebase\api\ClientDB;
use Safebase\controller\CntrlAppli;

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

$cntrl = new CntrlAppli;
$api = new ClientDB($type, $host, $port, $db_name, $username, $password);
// $cron = new TacheCron;
// $appDB = new Model;
//-----------------------------------------------------------------------------------------------
if ($method == 'get' and $route == '/') {
    $cntrl->getIndex();
} elseif ($method == 'get' and $segments[0] == 'api') {
    // Routes vers CRON
    if (isset($segments[1]) and $segments[1] == 'cron') {
        echo ('<br>route cron<br>');
        if (isset($segments[2]) and $segments[2] == 'create') {
            echo ('create');
            $cron->createCron();
        } else if (isset($segments[2]) and $segments[2] == 'delete') {
            $cron->deleteTask();
        } else if (isset($segments[2]) and $segments[2] == 'test1') {
            $taskname = 'test25';
            $taskSchedule = 'mois';
            $timeSet = '22:10';
            $startingDate = '10/10/2024'; //yyyy-mm-dd
            $scriptPath = 'PC:\wamp64\bin\php\php8.2.18\php.exe';
            $clientDB_id = '1';
            $cron = new TacheCron($taskname, $taskSchedule, $timeSet, $startingDate, $scriptPath, $clientDB_id);
            echo 'route test1 <br>';
            $cron->createCron();
        }
    } elseif ($method == 'get' and $segments[1] == 'testconnection') {
        $api->testConnection();
    } elseif ($method == 'get' and $segments[1] == 'backup') {
        $api->createBackup();
    } elseif ($method == 'get' and $segments[1] == 'restoreDB') {
        $api->restoreDB();
    }
    // route vers index
} else {
    $cntrl->getIndex();
}
