<?php

namespace common\models\person;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PersonSearch represents the model behind the search form of `common\models\person\Person`.
 */
class PersonSearch extends Person
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'generation_id', 'gender_id', 'parent_marriage_id', 'citizenship_id', 'education_id', 'creator_id', 'modifier_id'], 'integer'],
            [['title', 'name', 'surname', 'fathers_name', 'date_of_birth', 'date_of_death', 'description', 'address', 'phone', 'profession', 'created_at', 'updated_at'], 'safe'],
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
        $query = Person::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
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
            'date_of_birth' => $this->date_of_birth,
            'date_of_death' => $this->date_of_death,
            'generation_id' => $this->generation_id,
            'gender_id' => $this->gender_id,
            'parent_marriage_id' => $this->parent_marriage_id,
            'citizenship_id' => $this->citizenship_id,
            'education_id' => $this->education_id,
            'creator_id' => $this->creator_id,
            'modifier_id' => $this->modifier_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'surname', $this->surname])
            ->andFilterWhere(['like', 'fathers_name', $this->fathers_name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'profession', $this->profession]);

        return $dataProvider;
    }
}
