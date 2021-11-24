<?php

namespace d4yii2\costcard\models;

use d3system\yii2\db\D3Db;
use d4yii2\costcard\dictionaries\CcUnitDictionary;
use d4yii2\costcard\models\base\CcUnit as BaseCcUnit;

/**
 * This is the model class for table "cc_unit".
 */
class CcUnit extends BaseCcUnit
{
    public static function getDb()
    {
        return D3Db::clone();
    }


    public function afterSave($insert, $changedAttributes): void
    {
        parent::afterSave($insert, $changedAttributes);
        CcUnitDictionary::clearCache();
    }

    public function afterDelete(): void
    {
        parent::afterDelete();
        CcUnitDictionary::clearCache();
    }
}
