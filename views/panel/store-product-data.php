<?php

use d3system\dictionaries\SysModelsDictionary;
use d4yii2\costcard\dictionaries\CcDimensionDictionary;
use d4yii2\costcard\models\CcCostCard;
use eaBlankonThema\widget\ThButton;
use eaBlankonThema\widget\ThDataListColumn;
use eaBlankonThema\widget\ThGridView;
use eaBlankonThema\widget\ThPanel;
use d3modules\d4storei\models\D4StoreStoreProduct;
use yii\data\ActiveDataProvider;

/**
 * @var $storeProduct D4StoreStoreProduct
 */

$activeDataProvider = new ActiveDataProvider([
    'query' => CcCostCard::find()
        ->where([
            'record_sys_model_id' => SysModelsDictionary::getIdByClassName(\d4yii2\d4store\models\D4StoreStoreProduct::class),
            'record_id' => $storeProduct->id
        ])
]);

$title = Yii::t('costcard', 'Cost Card');
if (!$activeDataProvider->count) {
    $buttonCreate = ThButton::widget([
        'label' => 'Create',
        'type' => ThButton::TYPE_PRIMARY,
        'size' => ThButton::SIZE_XSMALL,
        'link' => [
            '/ncltmanucature/cost-card/create',
            'storeProductId' => $storeProduct->id
        ]
    ]);
    echo ThPanel::widget([
        'header' => $title . ' ' . $buttonCreate,
    ]);
} else {
    $buttonDelete = ThButton::widget([
        'label' => 'Delete',
        'type' => ThButton::TYPE_DANGER,
        'size' => ThButton::SIZE_XSMALL,
        'link' => [
            '/ncltmanucature/cost-card/delete',
            'storeProductId' => $storeProduct->id
        ]
    ]);
    echo ThPanel::widget([
        'header' => $title . ' ' . $buttonDelete,
        'body' => ThGridView::widget([
            'dataProvider' => $activeDataProvider,
            'actionColumnTemplate' => '',
            'columns' => [
                [
                    'attribute' => 'dimension_id',
                    'class' => ThDataListColumn::class,
                    'list' => CcDimensionDictionary::getFullList()
                ],
                'total_amount'

            ]
        ])
    ]);
}
