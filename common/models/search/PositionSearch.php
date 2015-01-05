<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Position;

/**
 * PositionSearch represents the model behind the search form about `common\models\Position`.
 * @var string grid_name
 */
class PositionSearch extends Position
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'grid_id', 'stage_id', 'next_position'], 'integer'],
        ];
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
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Position::find()
            ->with('grid')
            ->with('stage')
            ->with('next')
        ;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if ($this->load($params) && !$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'grid_id' => $this->grid_id,
            'stage_id' => $this->stage_id,
            'next_position' => $this->next_position,
        ]);

        return $dataProvider;
    }
}
