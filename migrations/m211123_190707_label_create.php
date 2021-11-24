<?php

use yii\db\Migration;

class m211123_190707_label_create  extends Migration {

    public function safeUp() { 
        $this->execute('
            CREATE TABLE `cc_label` (
              `id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
              `name` VARCHAR (50) NOT NULL COMMENT \'Label Name\',
              `sys_model_id` TINYINT UNSIGNED NOT NULL COMMENT \'Sys Model\',
              `model_record_id` INT UNSIGNED COMMENT \'Record\',
              PRIMARY KEY (`id`),
              FOREIGN KEY (`sys_model_id`) REFERENCES `sys_models` (`id`)
            );        
        ');
    }

    public function safeDown() {
        echo "m211123_190707_label_create cannot be reverted.\n";
        return false;
    }
}
