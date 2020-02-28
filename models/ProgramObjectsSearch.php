<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProgramObjects;

/**
 * ProgramObjectsSearch represents the model behind the search form of `app\models\ProgramObjects`.
 */
class ProgramObjectsSearch extends ProgramObjects
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_org', 'id_priority', 'id_program', 'year', 'system_status'], 'integer'],
            [['name', 'assignment', 'regulation', 'event_type', 'note', 'created_at', 'updated_at'], 'safe'],
            [['square', 'wear', 'finance_sum', 'coFinancing'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = ProgramObjects::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_org' => $this->id_org,
            'id_priority' => $this->id_priority,
            'id_program' => $this->id_program,
            'square' => $this->square,
            'year' => $this->year,
            'wear' => $this->wear,
            'finance_sum' => $this->finance_sum,
            'coFinancing' => $this->coFinancing,
            'system_status' => $this->system_status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'assignment', $this->assignment])
            ->andFilterWhere(['like', 'regulation', $this->regulation])
            ->andFilterWhere(['like', 'event_type', $this->event_type])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
