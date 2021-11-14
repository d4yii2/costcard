<?php
namespace d4yii2\costcard;

use Yii;

class LeftMenu {

    public function list()
    {
        $user = Yii::$app->user;
        return [
            [
                'label' => Yii::t('costcard', '????'),
                'type' => 'submenu',
                //'icon' => 'truck',
                'url' => ['/costcard/????/index'],
            ],
        ];
    }
}
