<?php

namespace d4yii2\costcard\dictionaries;

use Yii;
use d4yii2\costcard\models\CcModels;
use yii\helpers\ArrayHelper;

class CcModelsDictionary
{

    private const CACHE_KEY_LIST = 'CcModelsDictionaryList';
    public static function getList(): array
    {
        return Yii::$app->cache->getOrSet(
            self::CACHE_KEY_LIST,
            static function () {
                return ArrayHelper::map(
                    CcModels::find()
                        ->select([
                            'id' => '`cc_models`.`sys_model_id`' ,
                            'name' => '`cc_models`.`class_name`',
                        ])
                        ->orderBy([
                            '`cc_models`.`class_name`' => SORT_ASC,
                        ])
                        ->asArray()
                        ->all(),
                    'id',
                    'name'
                );
            },
            60 * 60
        );
    }


    /**
    * get label
    * @param int $id
    * @return string|null
    */
    public static function getLabel(int $id)
    {
        return self::getList()[$id]??null;
    }

    public static function clearCache(): void
    {
        Yii::$app->cache->delete(self::CACHE_KEY_LIST);
    }


}
