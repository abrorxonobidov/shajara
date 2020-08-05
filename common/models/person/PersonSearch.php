<?php

namespace common\models\person;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PersonSearch represents the model behind the search form of `common\models\person\Person`.
 *
 * @property string fullIdentity
 */
class PersonSearch extends Person
{


    public $fullIdentity;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'generation_id', 'gender_id', 'parent_marriage_id'], 'integer'],
            [['fullIdentity', 'date_of_birth', 'date_of_death', 'address'], 'safe'],
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

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);

        $dataProvider->sort->attributes['fullIdentity'] = [
            'asc' => ['surname' => SORT_ASC, 'name' => SORT_ASC, 'fathers_name' => SORT_ASC, 'title' => SORT_ASC],
            'desc' => ['surname' => SORT_DESC, 'name' => SORT_DESC, 'fathers_name' => SORT_DESC, 'title' => SORT_DESC]
        ];

        $this->load($params);

        if (!$this->validate()) return $dataProvider;

        $query->andFilterWhere([
            'id' => $this->id,
            'generation_id' => $this->generation_id,
            'gender_id' => $this->gender_id,
            'parent_marriage_id' => $this->parent_marriage_id
        ]);

        $query
            ->andFilterWhere(['like', "CONCAT(surname, name, fathers_name, '(', REPLACE(title, ' ', ''), ')')", str_replace([' ', '-'], '', $this->fullIdentity)])
            ->andFilterWhere(['like', 'address', $this->address]);

        if ($this->date_of_birth)
            $query
                ->andWhere([
                    'between',
                    'date_of_birth',
                    date("Y-m-d", strtotime(substr($this->date_of_birth, 0, 10))),
                    date("Y-m-d", strtotime(substr($this->date_of_birth, 13, 10)))
                ]);

        if ($this->date_of_death)
            $query
                ->andWhere([
                    'between',
                    'date_of_death',
                    date("Y-m-d", strtotime(substr($this->date_of_death, 0, 10))),
                    date("Y-m-d", strtotime(substr($this->date_of_death, 13, 10)))
                ]);

        return $dataProvider;
    }
}
