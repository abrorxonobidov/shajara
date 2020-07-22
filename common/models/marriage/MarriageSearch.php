<?php

namespace common\models\marriage;

use yii\data\ActiveDataProvider;

/**
 * MarriageSearch represents the model behind the search form of `common\models\marriage\Marriage`.
 */
class MarriageSearch extends Marriage
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'husband_id', 'wife_id', 'order_husband', 'order_wife', 'status_id', 'creator_id', 'modifier_id'], 'integer'],
            [['date_of_marriage', 'date_of_divorce', 'description', 'created_at', 'updated_at'], 'safe'],
        ];
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
        $query = Marriage::find();

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
            'husband_id' => $this->husband_id,
            'wife_id' => $this->wife_id,
            'date_of_marriage' => $this->date_of_marriage,
            'date_of_divorce' => $this->date_of_divorce,
            'order_husband' => $this->order_husband,
            'order_wife' => $this->order_wife,
            'status_id' => $this->status_id,
            'creator_id' => $this->creator_id,
            'modifier_id' => $this->modifier_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
