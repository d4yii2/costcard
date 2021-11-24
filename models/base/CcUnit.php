<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace d4yii2\costcard\models\base;

use Yii;

/**
 * This is the base-model class for table "cc_unit".
 *
 * @property integer $id
 * @property string $code
 *
 * @property \d4yii2\costcard\models\CcCostCard[] $ccCostCards
 * @property string $aliasModel
 */
abstract class CcUnit extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'cc_unit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            'required' => [['code'], 'required'],
            'tinyint Unsigned' => [['id'],'integer' ,'min' => 0 ,'max' => 255],
            [['code'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('costcard', 'ID'),
            'code' => Yii::t('costcard', 'Code'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCcCostCards()
    {
        return $this->hasMany(\d4yii2\costcard\models\CcCostCard::className(), ['unit_id' => 'id'])->inverseOf('unit');
    }


    
    /**
     * @inheritdoc
     * @return \d4yii2\costcard\models\CcUnitQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \d4yii2\costcard\models\CcUnitQuery(get_called_class());
    }

}
