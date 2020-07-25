<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 25-Jul-20
 * Time: 17:27
 */

namespace frontend\widgets;

use yii\bootstrap\Html;
use yii\base\Widget;
use common\models\marriage\Marriage;
use common\models\person\Person;
use kartik\grid\GridView;

/**
 * Class MarriagesGridWidget
 * @property \common\models\person\Person $person
 */
class MarriagesGridWidget extends Widget
{

    public $person;

    public function run()
    {

        $person = $this->person;

        if ($person->gender_id == Person::GENDER_MALE) {
            $label = 'Xotin';
            $target = 'wife';
            $order = 'husband';
        } else {
            $label = 'Er';
            $order = 'wife';
            $target = 'husband';
        }

        $view = Html::tag('h3', 'Nikohlar va farzandlar');

        if (($marriages = $person->marriages) > null) {
            $view .= GridView::widget([
                'dataProvider' => new \yii\data\ArrayDataProvider(['allModels' => $marriages]),
                'summary' => false,
                'columns' => [
                    'order_' . $order,
                    [
                        'label' => $label,
                        'value' => function (Marriage $marriage) use ($person, $target) {
                            $pair = $marriage->{$target};
                            /** @var $pair Person */
                            return Html::a($pair->fullIdentity, ['person/view', 'id' => $pair->id], ['title' => 'Shaxsni ko‘rish', 'target' => '_blank']);
                        },
                        'format' => 'raw'
                    ],
                    'date_of_marriage',
                    'date_of_divorce',
                    'status',
                    [
                        'value' => function (Marriage $marriage) {
                            return Html::a(Html::icon('eye-open'), ['marriage/view', 'id' => $marriage->id], ['title' => 'Nikohni ko‘rish', 'target' => '_blank']);
                        },
                        'format' => 'raw'
                    ],
                    [
                        'class' => 'kartik\grid\ExpandRowColumn',
                        'allowBatchToggle' => false,
                        'detailAnimationDuration' => 0,
                        'value' => function () {
                            return GridView::ROW_EXPANDED;
                        },
                        'detail' => function (Marriage $marriage) {
                            $description = $marriage->description ? '<b>Izoh</b>: ' . Html::tag('p', $marriage->description) : '';
                            if (($childrenModels = $marriage->children) !== null) {
                                $description .= '<p><b>Farzandlar:</b> ' . Html::tag('span', count($childrenModels), ['class' => 'badge']) . '</p>'
                                    . GridView::widget([
                                        'summary' => false,
                                        'dataProvider' => new \yii\data\ArrayDataProvider([
                                            'allModels' => $marriage->children,
                                            'sort' => [
                                                'attributes' => ['date_of_birth', 'date_of_death', 'generation', 'gender'],
                                                'defaultOrder' => ['date_of_birth' => SORT_ASC]
                                            ],
                                            'pagination' => ['pageSize' => 0]
                                        ]),
                                        'columns' => [
                                            ['class' => 'yii\grid\SerialColumn', 'header' => 'T/r'],
                                            [
                                                'attribute' => 'fullIdentity',
                                                'value' => function (Person $person) {
                                                    return Html::a($person->fullIdentity, ['person/view', 'id' => $person->id], ['target' => '_blank']);
                                                },
                                                'format' => 'raw'
                                            ],
                                            'date_of_birth',
                                            'date_of_death',
                                            'generation',
                                            'gender',
                                        ]
                                    ]);
                            };
                            return $description;
                        },
                        'headerOptions' => ['class' => 'kartik-sheet-style'],
                        'expandOneOnly' => false,
                        'expandTitle' => 'Ochish',
                        'collapseTitle' => 'Yopish',
                        'expandAllTitle' => 'Barchasini ochish',
                        'collapseAllTitle' => 'Barchasini yopish',
                        'enableRowClick' => true,
                    ],
                ]
            ]);

        } else {
            $view .= 'Ma’lumot topilmadi';
        };

        return $view;
    }

}