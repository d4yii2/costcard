<?php

namespace d4yii2\costcard\interfces;

interface CreateCostCards
{
    public static function loadById(
        int $sysCompanyId,
        int $id
    );

    public static function migration();


    /**
     * @throws \d3system\exceptions\D3ActiveRecordException
     * @throws \yii\db\Exception|\yii\base\Exception
     */
    public function createCostCards(object $model): void;
}
