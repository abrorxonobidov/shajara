<?php

namespace common\models\marriage;

use common\models\person\Person;
use yii\data\ActiveDataProvider;

/**
 * MarriageSearch represents the model behind the search form of `common\models\marriage\Marriage`.
 *
 * @property string $identity_search_id
 *
 * @property Person $person
 */
class MarriageSearch extends Marriage
{


    public $identity_search_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status_id', 'identity_search_id'], 'integer'],
            [['date_of_marriage', 'date_of_divorce', 'description'], 'safe'],
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
        $query = Marriage::find()
            ->alias('m')
            ->leftJoin(['h' => Person::tableName()], 'h.id = m.husband_id')
            ->leftJoin(['w' => Person::tableName()], 'w.id = m.wife_id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
                'attributes' => [
                    'id',
                    'date_of_marriage',
                    'date_of_divorce',
                    'status_id',
                    'description',
                    'identity_search_id' => [
                        'asc' => ['h.surname' => SORT_ASC, 'h.name' => SORT_ASC, 'h.fathers_name' => SORT_ASC, 'h.title' => SORT_ASC, 'w.surname' => SORT_ASC, 'w.name' => SORT_ASC, 'w.fathers_name' => SORT_ASC, 'w.title' => SORT_ASC],
                        'desc' => ['h.surname' => SORT_DESC, 'h.name' => SORT_DESC, 'h.fathers_name' => SORT_DESC, 'h.title' => SORT_DESC, 'w.surname' => SORT_DESC, 'w.name' => SORT_DESC, 'w.fathers_name' => SORT_DESC, 'w.title' => SORT_DESC],
                    ],
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) return $dataProvider;

        $query
            ->andFilterWhere([
                'm.id' => $this->id,
                'm.status_id' => $this->status_id,
            ])
            ->andFilterWhere([
                'or',
                ['m.husband_id' => $this->identity_search_id],
                ['m.wife_id' => $this->identity_search_id],
            ])
            ->andFilterWhere(['like', 'm.description', $this->description]);

        if ($this->date_of_marriage)
            $query
                ->andWhere([
                    'between',
                    'm.date_of_marriage',
                    date("Y-m-d", strtotime(substr($this->date_of_marriage, 0, 10))),
                    date("Y-m-d", strtotime(substr($this->date_of_marriage, 13, 10)))
                ]);

        if ($this->date_of_divorce)
            $query
                ->andWhere([
                    'between',
                    'm.date_of_divorce',
                    date("Y-m-d", strtotime(substr($this->date_of_divorce, 0, 10))),
                    date("Y-m-d", strtotime(substr($this->date_of_divorce, 13, 10)))
                ]);

        return $dataProvider;
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Person::class, ['id' => 'identity_search_id']);
    }


}
