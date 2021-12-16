<?php

use yii\db\Migration;

class m211216_181600_d4yii2_costcard_label_add_add_model_record_id  extends Migration {

    public function safeUp() { 
        $this->execute('
            ALTER TABLE `cc_label`
              ADD COLUMN `add_sys_model_id` TINYINT UNSIGNED NULL COMMENT \'Add model\' AFTER `model_record_id`,
              ADD COLUMN `add_model_record_id` INT UNSIGNED NULL COMMENT \'Add Record\' AFTER `add_sys_model_id`,
              ADD FOREIGN KEY (`add_sys_model_id`) REFERENCES `sys_models` (`id`)
              ;            
                    
        ');
    }

    public function safeDown() {
        echo "m211216_181600_d4yii2_costcard_label_add_add_model_record_id cannot be reverted.\n";
        return false;
    }
}
