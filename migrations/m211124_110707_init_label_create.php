<?php

use yii\db\Migration;

class m211124_110707_init_label_create  extends Migration {

    public function safeUp() { 
        $this->execute('
            CREATE TABLE `cc_label` (
              `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
              `name` varchar(50) CHARSET utf8  NOT NULL COMMENT \'Label Name\',
              `sys_model_id` tinyint(3) unsigned NOT NULL COMMENT \'Sys Model\',
              `model_record_id` int(10) unsigned DEFAULT NULL COMMENT \'Record\',
              PRIMARY KEY (`id`),
              KEY `sys_model_id` (`sys_model_id`),
              CONSTRAINT `cc_label_ibfk_1` FOREIGN KEY (`sys_model_id`) REFERENCES `sys_models` (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=latin1
                    
        ');
    }

    public function safeDown() {
        echo "m211124_110707_init_label_create cannot be reverted.\n";
        return false;
    }
}
