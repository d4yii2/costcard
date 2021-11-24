<?php

use yii\db\Migration;

class m211123_190707_Cost_card_add_labe  extends Migration {

    public function safeUp() { 
        $this->execute('
            ALTER TABLE `cc_cost_card`
              ADD COLUMN `label_id` SMALLINT UNSIGNED NULL COMMENT \'Label\' AFTER `dimension_record_id`,
              ADD CONSTRAINT `cc_cost_card_ibfk_label` FOREIGN KEY (`label_id`) REFERENCES `cc_label` (`id`);
            
                    
        ');
    }

    public function safeDown() {
        echo "m211123_190707_Cost_card_add_labe; cannot be reverted.\n";
        return false;
    }
}
