<?php

declare (strict_types = 1);

namespace Safebase;

use Safebase\entity\Backup;
use Safebase\api\testconnection;
use Safebase\Controller\AlertController;
use Safebase\Controller\BackupController;
use Safebase\controller\CntrlAppli;
use Safebase\Controller\CronController;
use Safebase\Controller\DatabaseController;
use Safebase\Controller\RestoreController;
use Safebase\dao\DaoAppli;
use Safebase\entity\Cron;
use Safebase\entity\Database;

require_once __DIR__ . '/vendor/autoload.php';

/* router de l'application */

//ex: localhost:3000/ressource?niveau=2
$uri = $_SERVER['REQUEST_URI'];
$route = explode('?', $uri)[0];
$method = strtolower($_SERVER['REQUEST_METHOD']);
//separe les segments de l'adresse
$segments = explode('/', trim($route, '/'));
$cntrl = new CntrlAppli;
$api = new testconnection;
$dao = new DaoAppli;
$cntrlDb = new DatabaseController;
$cntrlBackup = new BackupController;
$cntrlAlert = new AlertController;
$cntrlRestore = new RestoreController;

//----------------------------------------------------------------------------------------------
// routes for databases
if ($segments[0] == 'database') {
    if ($method=='get'){
        if (isset($segments[1])) {
            // if param:id
            //todo
        } else {
            $cntrl->getIndex();
        }
    } elseif ($method == "post"){

        $database = new Database();
        $database->create();
    
        
    } elseif ($method == "put") {
        //methode update to do
    } elseif ($method == "delete"){
        $database = new Database();
        $response = $database->delete($segments[1]);
        echo json_encode(['message' => $response]);
        return;
    } 
} elseif ($segments[0] == 'backup'){
    if ($method == 'delete'){
        // Delete backup

        $backup = new Backup();
        $response = $backup->deleteBackup(intVal($segments[1]));
        
        echo json_encode(['message' => $response]);
        return;
    }
}
elseif ($segments[0] == 'task') {
    if ($method=='get'){
        if (isset($segments[1]) and $segments[1]) {
            // if param:id
            //todo
        } else {
            $cntrlCron = new CronController;
            $cntrlCron->displayCron();
        }
    } elseif ($method == "post"){
        $cron = new Cron();
        $cron->create();
    } elseif ($method == "put") {
        if (isset($segments[2])){
            $cntrlCron->updateCron($segments[2]);
        }

    } elseif ($method == "DELETE"){
        $Cron = new Cron(); 
        $cron->delete($_GET['id']);
    } 
} elseif ($segments[0] == 'Save') {
    $cntrlBackup->displayBackup();
} elseif ($segments[0] == 'restore') {
    $cntrlRestore->displayBackup();
} elseif ($segments[0] == 'Alert') {
    $cntrlAlert->displayAlert();
}
else 
    $cntrl->getIndex();



