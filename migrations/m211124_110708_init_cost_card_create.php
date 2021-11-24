<?php

use yii\db\Migration;

class m211124_110708_init_cost_card_create  extends Migration {

    public function safeUp() { 
        $this->execute('
            CREATE TABLE `cc_cost_card` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `sys_company_id` smallint(5) unsigned NOT NULL,
              `previos_cost_card_id` int(10) unsigned DEFAULT NULL COMMENT \'Previos Cost Card\',
              `record_sys_model_id` tinyint(10) unsigned NOT NULL COMMENT \'Record Model\',
              `record_id` int(10) unsigned NOT NULL COMMENT \'Record\',
              `dimension_id` tinyint(3) unsigned NOT NULL COMMENT \'Dimension\',
              `qnt` decimal(13,3) unsigned NOT NULL COMMENT \'Quantity\',
              `unit_id` tinyint(3) unsigned NOT NULL COMMENT \'Unit\',
              `unit_price` decimal(10,3) unsigned NOT NULL COMMENT \'Unit Price\',
              `total_amount` decimal(10,3) unsigned NOT NULL COMMENT \'Total amount\',
              `dimension_model_id` tinyint(3) unsigned NOT NULL COMMENT \'Dimension model\',
              `dimension_record_id` int(10) unsigned NOT NULL COMMENT \'Dimension record\',
              `label_id` smallint(5) unsigned DEFAULT NULL COMMENT \'Label\',
              PRIMARY KEY (`id`),
              KEY `pack_id` (`record_sys_model_id`),
              KEY `prev_pack` (`previos_cost_card_id`),
              KEY `sys_model_id` (`dimension_model_id`),
              KEY `dimension_id` (`dimension_id`),
              KEY `unit_id` (`unit_id`),
              KEY `cc_cost_card_ibfk_label` (`label_id`),
              CONSTRAINT `cc_cost_card_ibfk_dimension` FOREIGN KEY (`dimension_id`) REFERENCES `cc_dimension` (`id`),
              CONSTRAINT `cc_cost_card_ibfk_dimension_sys_model` FOREIGN KEY (`dimension_model_id`) REFERENCES `sys_models` (`id`),
              CONSTRAINT `cc_cost_card_ibfk_label` FOREIGN KEY (`label_id`) REFERENCES `cc_label` (`id`),
              CONSTRAINT `cc_cost_card_ibfk_record_sys_model` FOREIGN KEY (`record_sys_model_id`) REFERENCES `sys_models` (`id`),
              CONSTRAINT `cc_cost_card_ibfk_unit` FOREIGN KEY (`unit_id`) REFERENCES `cc_unit` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1
                    
        ');
    }

    public function safeDown() {
        echo "m211124_110707_init_cost_card_create cannot be reverted.\n";
        return false;
    }
}
