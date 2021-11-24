<?php

namespace d4yii2\costcard\models;

use d3system\yii2\db\D3Db;
use d4yii2\costcard\dictionaries\CcDimensionDictionary;
use d4yii2\costcard\models\base\CcDimension as BaseCcDimension;

/**
 * This is the model class for table "cc_dimension".
 */
class CcDimension extends BaseCcDimension
{
    public static function getDb()
    {
        return D3Db::clone();
    }


    public function afterSave($insert, $changedAttributes): void
    {
        parent::afterSave($insert, $changedAttributes);
        CcDimensionDictionary::clearCache();
    }

    public function afterDelete(): void
    {
        parent::afterDelete();
        CcDimensionDictionary::clearCache();
    }
}
