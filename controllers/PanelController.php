<?php

namespace d4yii2\costcard\controllers;

use d3modules\d4storei\models\D4StoreStoreProduct;
use unyii2\yii2panel\Controller;
use yii\filters\AccessControl;

class PanelController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    /**
                     * standard definition
                     */
                    [
                        'allow' => true,
                        'actions' => [
                            'store-product-data',
                        ],
                        'roles' => [
                            '@',
                        ],
                    ],
                ],
            ],
        ];
    }

    public function actionStoreProductData(int $storeProductId)
    {
        if (!$storeProduct = D4StoreStoreProduct::findForController($storeProductId)) {
            return '';
        }
        return $this->render('store-product-data', [
            'storeProduct' => $storeProduct
        ]);
    }
}
