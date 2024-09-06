<?php

declare(strict_types=1);

namespace Safebase;

use Safebase\api\tachesCron;
use Safebase\api\testconnection;
use Safebase\controller\CntrlAppli;

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
$cntrl = new CntrlAppli;
$api = new testconnection;
$cron = new TachesCron;
//-----------------------------------------------------------------------------------------------
if ($method == 'get' and $route == '/') {
    $cntrl->getIndex();
} elseif ($method == 'get' and $segments[0] == 'api') {
    // Routes vers CRON
    if (isset($segments[2]) and $segments[1] == 'cron') {
        echo('cron');
        if (isset($segments[2]) and $segments[2] == 'create') {
            echo('create');
            $cron->createCron();
        } else if (isset($segments[2]) and $segments[2] == 'delete') {
            $cron->deleteTaskCron();
        }

    } elseif ($method == 'get' and $segments[1] == 'testconnection') {
        $type = "mysql";
        $url = "localhost";
        $port = "default";
        $database = "echangeJeune";
        $user = "root";
        $password = "toto";

        $api->test($type, $url, $port, $database, $user, $password);
    }
// route vers index
} else {
    $cntrl->getIndex();
}
