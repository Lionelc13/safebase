<?php

declare(strict_types=1);

namespace Safebase;

use Safebase\api\tachesCron;
use Safebase\api\ClientDB;
use Safebase\controller\CntrlAppli;

// phpinfo();
// die();
require_once __DIR__ . '/vendor/autoload.php';

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
$cron = new TachesCron;
//-----------------------------------------------------------------------------------------------
if ($method == 'get' and $route == '/') {
    $cntrl->getIndex();
} elseif ($method == 'get' and $segments[0] == 'api') {
    // Routes vers CRON
    if (isset($segments[2]) and $segments[1] == 'cron') {
        echo ('cron');
        if (isset($segments[2]) and $segments[2] == 'create') {
            echo ('create');
            $cron->createCron();
        } else if (isset($segments[2]) and $segments[2] == 'delete') {
            $cron->deleteTaskCron();
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
