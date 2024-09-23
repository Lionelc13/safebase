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
<<<<<<< HEAD
        $databases = $dao->getListDatabase();
=======
>>>>>>> origin/lionel
        require 'src/view/Backups.php';
    }
    
}
