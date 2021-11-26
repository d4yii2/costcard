<?php

namespace d4yii2\costcard\models;

use d3system\dictionaries\SysModelsDictionary;
use d3system\yii2\db\D3ActiveQuery;

/**
 * This is the ActiveQuery class for [[CcCostCard]].
 *
 * @see CcCostCard
 */
class CcCostCardQuery extends D3ActiveQuery
{
    /**
     * @throws \d3system\exceptions\D3ActiveRecordException
     */
    public function whereRecordModel(object $model): CcCostCardQuery
    {
        return $this->where([
            'cc_cost_card.record_sys_model_id' => SysModelsDictionary::getIdByClassName(get_class($model)),
            'cc_cost_card.record_id' => $model->id
        ]);
    }
}
