<?php

namespace d4yii2\costcard\dictionaries;

use d3system\exceptions\D3ActiveRecordException;
use d4yii2\costcard\models\CcUnit;
use Yii;
use yii\db\Exception;
use yii\helpers\ArrayHelper;

class CcUnitDictionary
{

    private const CACHE_KEY_LIST = 'CcUnitDictionaryList';

    /**
     * @throws \yii\db\Exception
     * @throws \d3system\exceptions\D3ActiveRecordException
     */
    public static function getIdByName(string $name, bool $isFirstTime = true): int
    {
        $list = self::getList();
        if ($id = (int)array_search($name, $list, true)) {
            return $id;
        }
        if (!$isFirstTime) {
            throw new Exception('Added to CcUnit ' . $name . ', but not found');
        }
        $model = new CcUnit();
        $model->code = $name;
        if (!$model->save()) {
            throw new D3ActiveRecordException($model);
        }

        self::clearCache();
        return self::getIdByName($name, false);
    }

    public static function getList(): array
    {
        return Yii::$app->cache->getOrSet(
            self::CACHE_KEY_LIST,
            static function () {
                return ArrayHelper::map(
                    CcUnit::find()
                        ->select([
                            'id' => '`cc_unit`.`id`',
                            'name' => '`cc_unit`.`code`',
                            //'name' => 'CONCAT(code,\' \',name)'
                        ])
                        ->orderBy([
                            '`cc_unit`.`code`' => SORT_ASC,
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
    public static function getLabel(int $id): ?string
    {
        return self::getList()[$id] ?? null;
    }

    public static function clearCache(): void
    {
        Yii::$app->cache->delete(self::CACHE_KEY_LIST);
    }


}
