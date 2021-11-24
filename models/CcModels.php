<?php

namespace d4yii2\costcard\models;

use d4yii2\costcard\dictionaries\CcModelsDictionary;
use d4yii2\costcard\models\base\CcModels as BaseCcModels;

/**
 * This is the model class for table "cc_models".
 */
class CcModels extends BaseCcModels
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['class_name','unique','targetAttribute' => ['class_name','sys_model_id']],
        ]);
    }

    public function afterSave($insert, $changedAttributes): void
    {
        parent::afterSave($insert, $changedAttributes);
        CcModelsDictionary::clearCache();
    }

    public function afterDelete(): void
    {
        parent::afterDelete();
        CcModelsDictionary::clearCache();
    }
}
