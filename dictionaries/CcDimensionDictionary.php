<?php

namespace d4yii2\costcard\dictionaries;

use d3system\exceptions\D3ActiveRecordException;
use d4yii2\costcard\models\CcDimension;
use Yii;
use yii\base\Exception;
use yii\helpers\ArrayHelper;

class CcDimensionDictionary
{

    private const CACHE_KEY_LIST = 'CcDimensionDictionaryList';

    /**
     * @throws \d3system\exceptions\D3ActiveRecordException
     * @throws \yii\base\Exception
     */
    public static function getIdByName(string $name, int $sysCompanyId, bool $isFirstTime = true): int
    {
        $list = self::getList($sysCompanyId);
        if ($id = (int)array_search($name, $list, true)) {
            return $id;
        }
        if (!$isFirstTime) {
            throw new Exception('Added to CmdCmp ' . $name . ', but not found');
        }
        $model = new CcDimension();
        $model->sys_company_id = $sysCompanyId;
        $model->name = $name;
        if (!$model->save()) {
            throw new D3ActiveRecordException($model);
        }

        self::clearCache();
        return self::getIdByName($name, $sysCompanyId, false);
    }

    public static function getList(int $sysCompanyId): array
    {
        return Yii::$app->cache->getOrSet(
            self::createCacheKey($sysCompanyId),
            static function () use ($sysCompanyId) {
                return ArrayHelper::map(
                    CcDimension::find()
                        ->select([
                            'id' => '`cc_dimension`.`id`',
                            'name' => '`cc_dimension`.`name`',

                        ])
                        ->andWhere(['`cc_dimension`.`sys_company_id`' => $sysCompanyId])
                        ->orderBy([
                            '`cc_dimension`.`name`' => SORT_ASC,
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

    public static function getFullList(): array
    {
        return Yii::$app->cache->getOrSet(
            self::createCacheKey(0),
            static function () {
                return ArrayHelper::map(
                    CcDimension::find()
                        ->select([
                            'id' => '`cc_dimension`.`id`',
                            'name' => '`cc_dimension`.`name`',
                        ])
                        ->orderBy([
                            '`cc_dimension`.`name`' => SORT_ASC,
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
     * @param int $sysCompanyId
     * @param int $id
     * @return string|null
     */
    public static function getLabel(int $sysCompanyId, int $id): ?string
    {
        return self::getList($sysCompanyId)[$id] ?? null;
    }

    private static function createCacheKey($sysCompanyId): string
    {
        return self::CACHE_KEY_LIST . '-' . $sysCompanyId;
    }

    public static function clearCache(): void
    {
        foreach (CcDimension::find()
                     ->distinct()
                     ->select('sys_company_id')
                     ->column() as $sysCompanyId
        ) {
            Yii::$app->cache->delete(self::createCacheKey($sysCompanyId));
        }
    }
}
