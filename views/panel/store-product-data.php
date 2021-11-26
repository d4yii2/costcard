<?php

use aluksne\manufacture\models\CostCard\RkInvoiceProductPack;
use d3modules\d4storei\models\D4StoreStoreProduct;
use d3system\dictionaries\SysModelsDictionary;
use d4modules\manufacture\models\MAction;
use d4yii2\costcard\dictionaries\CcDimensionDictionary;
use d4yii2\costcard\models\CcCostCardSearch;
use eaBlankonThema\widget\ThButton;
use eaBlankonThema\widget\ThGridView;
use eaBlankonThema\widget\ThPanel;
use yii\helpers\Html;

/**
 * @var $storeProduct D4StoreStoreProduct
 */

$baseProduct = \d4yii2\d4store\models\D4StoreStoreProduct::findOne($storeProduct->id);

$costCardSearch = new CcCostCardSearch();
$activeDataProvider = $costCardSearch->search($baseProduct);
$activeDataProvider->pagination = false;

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
                    'attribute' => 'previos_cost_card_id',
                    'value' => static function (CcCostCardSearch $model) {
                        /**
                         * @todo kaut kā jāpārness uz configu
                         */
                        if (!$product = \d4yii2\d4store\models\D4StoreStoreProduct::findOne($model->prvRecordId)) {
                            return '-';
                        }
                        return Html::a(
                            $product->product->name,
                            [
                                '/d4storei/store-product/view',
                                'id' => $model->prvRecordId
                            ]
                        );
                    }
                ],
                [
                    'attribute' => 'dimension_id',
                    'value' => static function (CcCostCardSearch $model) {

                        $label = CcDimensionDictionary::getFullList()[$model->dimension_id] ?? '';
                        /**
                         * @todo kaut kā jāpārness uz configu
                         */
                        if ($model->dimension_model_id === SysModelsDictionary::getIdByClassName(\d3modules\rkinvoiceproduct\models\RkInvoiceProductPack::class)) {
                            /** @var $pack RkInvoiceProductPack */
                            if (!$pack = RkInvoiceProductPack::findOne($model->dimension_record_id)) {
                                return $label;
                            }
                            if (!$rkInvoiceId = $pack->invoiceProduct->invoice_id) {
                                return $label;
                            }
                            return Html::a(
                                $label,
                                [
                                    '/rkinvoiceproduct/invoice-product/edit-view',
                                    'invoiceId' => $rkInvoiceId,
                                    'openCollapsed' => $pack->invoice_product_id
                                ]
                            );
                        }

                        if ($model->dimension_model_id === SysModelsDictionary::getIdByClassName(MAction::class)) {
                            /** @var $action MAction */
                            if (!$action = MAction::findOne($model->dimension_record_id)) {
                                return $label;
                            }
                            if (!$task = $action->task) {
                                return $label;
                            }
                            return Html::a(
                                $label,
                                [
                                    '/manufacture/task/view',
                                    'id' => $task->id,
                                ]
                            );
                        }
                        return $label;
                    }
                ],
                'labelName',
                'total_amount'

            ]
        ])
    ]);
}
