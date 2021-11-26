<?php

namespace d4yii2\costcard\models;

use eaBlankonThema\widget\ThRmGridView;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CcCostCardSearch represents the model behind the search form about `d4yii2\costcard\models\CcCostCard`.
 */
class CcCostCardSearch extends CcCostCard
{

    public $dimensionName;
    public $labelName;
    public $prvRecordSysModelId;
    public $prvRecordId;
    public $productName;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'sys_company_id', 'previos_cost_card_id', 'record_sys_model_id', 'record_id', 'dimension_id', 'unit_id', 'dimension_model_id', 'dimension_record_id', 'label_id'], 'integer'],
            [['qnt', 'unit_price', 'total_amount'], 'number'],
            [['dimensionName','labelName'],'string'],
            [['prvRecordSysModelId','prvRecordId','productName'],'string'],
        ];
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'dimensionName' => 'Dimensija',
            'labelName' => 'Nosaukums',
            'productName' => 'Produkts',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param object|null $model
     * @return ActiveDataProvider
     * @throws \d3system\exceptions\D3ActiveRecordException
     */
    public function search(object $model = null): ActiveDataProvider
    {
        if (!$model) {
            $this->load(ThRmGridView::getMergedFilterStateParams());
        }
        if (!$this->validate()) {
            return new ActiveDataProvider([
                'query' => self::find(),

            ]);
        }

        $query = $this
            ->createQuery();
        if ($model) {
            $query->whereRecordModel($model);
        } else {
            $query
                ->addSelect([
                    'productName' => 'd3product_product.name'
                ])
                ->innerJoin(
                    'd4store_store_product',
                    'd4store_store_product.id = cc_cost_card.record_id'
                )
                ->innerJoin(
                    'd3product_product',
                    'd3product_product.id = d4store_store_product.product_id'
                )
            ;
        }
        return new ActiveDataProvider([
            'query' => $query,
            //'totalCount' => $totalCountQuery->count(),
            'pagination' => [
                'params' => ThRmGridView::getMergedFilterStateParams(),
            ],
            'sort' => [
                //'defaultOrder' => [
                //    'end' => SORT_DESC
                //],
                'params' => ThRmGridView::getMergedFilterStateParams(),
            ],
        ]);
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @return ActiveDataProvider
     */
    public function searchXls(): ActiveDataProvider
    {

        $this->load(ThRmGridView::getMergedFilterStateParams());

        if (!$this->validate()) {
            return new ActiveDataProvider([
                'query' => self::find(),

            ]);
        }

        $query = $this->createQuery();
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => [
                //'defaultOrder' => [
                //    'end' => SORT_DESC
                //],
                'params' => ThRmGridView::getMergedFilterStateParams(),
            ],
        ]);
    }


    public function createQuery(): CcCostCardQuery
    {
        return self::find()
            ->select([
                'cc_cost_card.*',
                'dimensionName' => 'cc_dimension.name',
                'labelName' => 'cc_label.name',
                'prvRecordSysModelId' => 'prvCostCard.record_sys_model_id',
                'prvRecordId' => 'prvCostCard.record_id'
            ])
            ->innerJoin(
                'cc_dimension',
                'cc_dimension.id = cc_cost_card.dimension_id'
            )
            ->innerJoin(
                'cc_label',
                'cc_label.id = cc_cost_card.label_id'
            )
            ->leftJoin(
                'cc_cost_card prvCostCard',
                'prvCostCard.id = cc_cost_card.previos_cost_card_id'
            )
            ->andFilterWhere([
                'cc_cost_card.id' => $this->id,
                'cc_cost_card.sys_company_id' => $this->sys_company_id,
                'cc_cost_card.previos_cost_card_id' => $this->previos_cost_card_id,
                'cc_cost_card.record_sys_model_id' => $this->record_sys_model_id,
                'cc_cost_card.record_id' => $this->record_id,
                'cc_cost_card.dimension_id' => $this->dimension_id,
                'cc_cost_card.qnt' => $this->qnt,
                'cc_cost_card.unit_id' => $this->unit_id,
                'cc_cost_card.unit_price' => $this->unit_price,
                'cc_cost_card.total_amount' => $this->total_amount,
                'cc_cost_card.dimension_model_id' => $this->dimension_model_id,
                'cc_cost_card.dimension_record_id' => $this->dimension_record_id,
                'cc_cost_card.label_id' => $this->label_id,
            ]);
    }
}