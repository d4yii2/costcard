<?php

use yii\db\Migration;

class m211124_110707_init_dimension_create  extends Migration {

    public function safeUp() { 
        $this->execute('
            CREATE TABLE `cc_dimension` (
              `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
              `sys_company_id` smallint(5) unsigned NOT NULL,
              `name` varchar(20) CHARACTER SET utf8 NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1
                    
        ');
    }

    public function safeDown() {
        echo "m211124_110707_init_dimension_create cannot be reverted.\n";
        return false;
    }
}
