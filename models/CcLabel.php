<?php

namespace d4yii2\costcard\models;

use d3system\dictionaries\SysModelsDictionary;
use d3system\exceptions\D3ActiveRecordException;
use d4yii2\costcard\models\base\CcLabel as BaseCcLabel;

/**
 * This is the model class for table "cc_label".
 */
class CcLabel extends BaseCcLabel
{
    /**
     * @throws \d3system\exceptions\D3ActiveRecordException
     */
    public static function findIdByModel(object $model): int
    {
        if ($id = self::find()
            ->select('id')
            ->where([
                'sys_model_id' => SysModelsDictionary::getIdByClassName(get_class($model)),
                'model_record_id' => $model->id
            ])->scalar()) {
            return $id;
        }
        $newModel = new self();
        $newModel->sys_model_id = SysModelsDictionary::getIdByClassName(get_class($model));
        $newModel->model_record_id = $model->id;
        $newModel->name = $model->getLabel();
        if (!$newModel->save()) {
            throw new D3ActiveRecordException($newModel);
        }

        return $newModel->id;
    }
}
