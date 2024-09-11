<?php
// Définir le chemin du fichier à créer à la racine
$filePath = __DIR__ . '/logs.log';

// Texte à écrire dans le fichier
$text = 'Hé ouiii !';

// Écrire le texte dans le fichier
file_put_contents($filePath, $text, FILE_APPEND); 