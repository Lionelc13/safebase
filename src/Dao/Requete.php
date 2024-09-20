<?php
namespace Safebase\dao;

class Requete {
    // Requetes pour lister
    public const SEL_TYPE_BASE = "SELECT id, nom, version 
                                    FROM type";
    public const SEL_CRON = "SELECT t.id, t.nom, recurrence, date_demarrage,ID_database, c.nom as dbase
                            FROM tache_cron t, client_Database c
                            WHERE t.ID_database = c.id";
    public const SEL_BACKUP = "SELECT b.id id, version,id_database , c.nom as dbase
                                FROM backup b, client_Database c
                                WHERE b.ID_database = c.id";
    public const SEL_CLIENT_DATABASE = "SELECT id, nom, password, port, url, used_type, user_database
                                        FROM client_database";
    public const SEL_ALERT = "  SELECT A.id, message, date_execution, nom
                                FROM alert A, client_database C
                                WHERE ID_DATABASE=  C.id";
    // Requetes d'insertion
    public const INS_DATABASE = "INSERT INTO client_database
         (nom,password, port,url, used_type, user_database, ID_Type)
        values(:nom, :password, :port, :url,:used_type, :user, :type_base)";
    public const INS_CRON = "INSERT INTO `tache_cron`(`nom`, `recurrence`, `date_demarrage`, `heure`, `ID_DATABASE`) 
                             VALUES (:nom, :recurrence, :date_demarrage, :heure,:ID_DATABASE)";
   // Requetes de suppression
   public const DEL_CLIENT_DATABASE = "DELETE FROM client_database WHERE id= :id"; 
   public const DEL_ALERT = "DELETE FROM alert WHERE id= :id";
   public const DEL_TASK_CRON = "DELETE FROM tache_cron WHERE id= :id";
    
}
