<?php

use yii\db\Migration;

class m211124_110707_init_unit_create  extends Migration {

    public function safeUp() { 
        $this->execute('
            CREATE TABLE `cc_unit` (
              `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
              `code` varchar(20) NOT NULL,
              KEY `id` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1        
        ');
    }

    public function safeDown() {
        echo "m211124_110707_init_unit_create cannot be reverted.\n";
        return false;
    }
}
