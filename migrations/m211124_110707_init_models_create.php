<?php

use yii\db\Migration;

class m211124_110707_init_models_create  extends Migration {

    public function safeUp() { 
        $this->execute('
            CREATE TABLE `cc_models` (
              `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
              `sys_model_id` tinyint(3) unsigned NOT NULL,
              `class_name` varchar(256) NOT NULL,
              PRIMARY KEY (`id`),
              KEY `sys_model_id` (`sys_model_id`),
              CONSTRAINT `cc_models_ibfk_1` FOREIGN KEY (`sys_model_id`) REFERENCES `sys_models` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1
                    
        ');
    }

    public function safeDown() {
        echo "m211124_110707_init_models_create cannot be reverted.\n";
        return false;
    }
}
