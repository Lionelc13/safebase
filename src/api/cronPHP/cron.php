<?php

// Chemin complet vers l'exécutable PHP et le script PHP
$phpPath = PHP_PATH;
$scriptPath = 'C:\wamp64\www\safebase\src\api\cronPHP\job1.php';

// Vérifie si le système d'exploitation est Windows
if (PHP_OS === "WINNT") {

    echo 'Création de la tâche cron sous Windows via PHP...';   

    // Commande pour créer la tâche cron
    $command = "schtasks /create /tn \"testCronPHP\" /tr \"$phpPath $scriptPath\" /sc daily /st 11:56";

    // Exécute la commande
    exec($command, $output, $result);
    

} elseif(PHP_OS === "Linux"){

    echo 'Création de la tâche cron sous Linux via PHP...';   

    // Définir la commande cron à ajouter
    $cronJob = '45 19 * * * ' . escapeshellcmd($phpPath) . ' ' . escapeshellarg($scriptPath);

    // Lire la crontab actuelle
    exec('crontab -l 2>/dev/null', $output, $result);

    // Ajouter la nouvelle tâche cron
    $currentCrontab = implode("\n", $output);
    $newCrontab = $currentCrontab . "\n" . $cronJob;

    // Écrire la nouvelle crontab
    $tmpFile = '/tmp/my_crontab';
    file_put_contents($tmpFile, $newCrontab);
    exec('crontab ' . escapeshellarg($tmpFile), $output, $result);

    // Supprimer le fichier temporaire
    unlink($tmpFile);

    // Vérifier si la tâche a été ajoutée avec succès
    if ($result === 0) {
        echo 'La tâche cron a été ajoutée avec succès.';
    } else {
        echo 'Une erreur est survenue lors de l\'ajout de la tâche cron.';
    }

}else {
    echo 'Le script doit être exécuté sous Windows ou Linux.';
}
