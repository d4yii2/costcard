<?php

namespace d4yii2\costcard;

use Yii;
use d3system\yii2\base\D3Module;

class Module extends D3Module
{
    public $controllerNamespace = 'd4yii2\costcard\controllers';

    public function getLabel(): string
    {
        return Yii::t('costcard','Cost Card');
    }
}
