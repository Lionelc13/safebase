<?php

declare(strict_types=1);

namespace Safebase;

use Safebase\api\tacheCron;
use Safebase\api\ClientDB;
use Safebase\model\Model;

$taskname = 'test1';
$taskSchedule = 'jour';
$timeSet = '22:10';
$startingDate = '2024-09-10';
$scriptPath = 'PC:\wamp64\bin\php\php8.2.18\php.exe';
$clientDB_id = '1';

// echo('<pre>');
// var_dump($GLOBALS);
// echo('<br><hr>');

$cron = new TacheCron($taskname, $taskSchedule, $timeSet, $startingDate, $scriptPath, $clientDB_id);
$cron->createCron();

