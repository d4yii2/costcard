<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace d4yii2\costcard\models\base;

use Yii;

/**
 * This is the base-model class for table "cc_dimension".
 *
 * @property integer $id
 * @property integer $sys_company_id
 * @property string $name
 *
 * @property \d4yii2\costcard\models\CcCostCard[] $ccCostCards
 * @property string $aliasModel
 */
abstract class CcDimension extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'cc_dimension';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            'required' => [['sys_company_id', 'name'], 'required'],
            'tinyint Unsigned' => [['id'],'integer' ,'min' => 0 ,'max' => 255],
            'smallint Unsigned' => [['sys_company_id'],'integer' ,'min' => 0 ,'max' => 65535],
            [['name'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('costcard', 'ID'),
            'sys_company_id' => Yii::t('costcard', 'Sys Company ID'),
            'name' => Yii::t('costcard', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCcCostCards()
    {
        return $this->hasMany(\d4yii2\costcard\models\CcCostCard::className(), ['dimension_id' => 'id'])->inverseOf('dimension');
    }


    
    /**
     * @inheritdoc
     * @return \d4modules\manufacture\models\CcDimensionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \d4modules\manufacture\models\CcDimensionQuery(get_called_class());
    }

}
