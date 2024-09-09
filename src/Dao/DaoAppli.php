<?php

namespace Safebase\dao;

use \PDO as PDO;

//require_once 'src/controller/Utilitaire.php';
class DaoAppli
{

    private PDO $db;
    // public function __construct(){
    //      $this->db = $this->getConnection();
    // }
    // On essai de se connecter à la base de données
    // private function getConnection() {
    //     $host       = "localhost";
    //     $db_name    = "echangeJeune";
    //     $username   = "Admin";
    //     $password   = "Azerty13";

    //     if (!isset($this->db)) {
    //         try {
    //             // $db = new PDO('mysql:host=127.0.0.1;charset=utf8;dbname=testdomi','muller','codapppw');
    //             $this->db = new PDO("mysql:host=".$host.";charset=utf8;dbname=".$db_name, $username, $password);
    //             $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //         } catch (\PDOException $e) {
    //                 echo('Echec de la connexion: ' . $e->getMessage());
    //             die();
    //         }
    //     }
    //     return $this->db;
    // }

    // On essai de se connecter à la base de données
    public function tryConnection($type, $host, $port, $db_name, $username, $password)
    {
        $monErreur = 'Connection réussie ! ';

        if (!isset($this->db)) {
            try {
                $this->db = new PDO($type . ":host=" . $host . ";port=" . $port . ";dbname=" . $db_name, $username, $password);
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e) {
                $monErreur = $this::retourneErreur($e->getCode(), $e->getMessage());
                // die($e->getCode() . ":" . $monErreur);
                echo ($monErreur);
            }
        }
        return $this->db;
    }

    public static function retourneErreur($codeErr, $message)
    {

        if ($codeErr == '23000') {
            if (strpos($message, 'Integrity') && (strpos($message, 'v_ema'))) {
                return 'cet email existe déjà!';
            }
        } elseif ($codeErr == '1049') {
            if (strpos($message, 'inconnue')) {
                return 'Impossible de trouver la base de données!';
            }
        } elseif ($codeErr == '1045') {
            if (strpos($message, 'Accès refusé')) {
                return 'Utilistateur ou mot de passe inconnu';
            }
        } elseif ($codeErr == '2002') {
            if (strpos($message, 'inconnu')) {
                return 'Impossible de contacter l URL de la base de données! Veuillez vérifier votre connexion';
            }
        } else {
            return $message;
        }
    }
}
