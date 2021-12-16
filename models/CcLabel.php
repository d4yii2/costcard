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
    public static function findIdByModel(object $model, object $addModel = null): int
    {
        $where = [
            'sys_model_id' => SysModelsDictionary::getIdByClassName(get_class($model)),
            'model_record_id' => $model->id
        ];
        if ($addModel) {
            $where['add_sys_model_id'] = SysModelsDictionary::getIdByClassName(get_class($addModel));
            $where['add_model_record_id'] = $addModel->id;
        }
        if ($id = self::find()
            ->select('id')
            ->where($where)->scalar()) {
            return $id;
        }
        $newModel = new self();
        $newModel->name = $model->getLabel();
        $newModel->sys_model_id = SysModelsDictionary::getIdByClassName(get_class($model));
        $newModel->model_record_id = $model->id;

        if ($addModel) {
            $newModel->name .= ' ' . $addModel->getLabel();
            $newModel->add_sys_model_id = SysModelsDictionary::getIdByClassName(get_class($addModel));
            $newModel->add_model_record_id = $addModel->id;
        }

        if (!$newModel->save()) {
            throw new D3ActiveRecordException($newModel);
        }

        return $newModel->id;
    }
}
