<?php

namespace d4yii2\costcard\models;

use d3system\dictionaries\SysModelsDictionary;
use d4yii2\costcard\dictionaries\CcDimensionDictionary;
use d4yii2\costcard\dictionaries\CcUnitDictionary;
use d4yii2\costcard\models\base\CcCostCard as BaseCcCostCard;

/**
 * This is the model class for table "cc_cost_card".
 */
class CcCostCard extends BaseCcCostCard
{
    public static function optsUnit(): array
    {
        return CcUnitDictionary::getList();
    }

    public static function optsDimension(): array
    {
        return CcDimensionDictionary::getFullList();
    }

    /**
     * @param $model
     * @return self[]
     * @throws \d3system\exceptions\D3ActiveRecordException
     */
    public static function findByRecordModelAll($model): array
    {
        return self::findAll([
            'record_sys_model_id' => SysModelsDictionary::getIdByClassName(get_class($model)),
            'record_id' => $model->id
        ]);
    }

}
