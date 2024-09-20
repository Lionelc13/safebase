<?php
namespace Safebase\Controller;

use Safebase\dao\DaoAppli;
use Safebase\entity\Database;

class BackupController extends CntrlAppli
{
    public function displayBackup()
    {
        $dao = new DaoAppli;
        $backups = $dao->getListBackup();
        $databases = $dao->getListDatabase();
        require 'src/view/Backups.php';
    }
    
}
