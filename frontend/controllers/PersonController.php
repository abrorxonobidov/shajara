<?php

namespace frontend\controllers;

use common\models\marriage\Marriage;
use Yii;
use common\models\person\Person;
use common\models\person\PersonSearch;
use yii\filters\AjaxFilter;
use yii\filters\ContentNegotiator;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * PersonController implements the CRUD actions for Person model.
 */
class PersonController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviour = parent::behaviors();

        $behaviour['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'delete' => ['POST'],
            ]
        ];

        $behaviour[] = [
            'class' => AjaxFilter::class,
            'only' => ['get-marriage'],
            'errorMessage' => 'Sahifa topilmadi'
        ];

        $behaviour[] = [
            'class' => ContentNegotiator::class,
            'only' => ['get-marriage'],  // in a controller
            'formats' => ['application/json' => Response::FORMAT_JSON]
        ];
        return $behaviour;
    }

    /**
     * Lists all Person models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PersonSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Person model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Person model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Person();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Person model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Person model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws mixed
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id) //todo make is_deleted = true
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Person model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Person the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Person::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param $text
     * @return mixed
     */
    public function actionGetMarriage($text)
    {
        if ($text === false) return Json::encode(['results' => ['id' => '', 'text' => '']]);
        $authorities = Marriage::find()
            ->select([
                'm.id',
                'text' => "CONCAT(h.surname, ' ', h.name, ' ', h.fathers_name, ' (', h.title, ')', ' - ', w.surname, ' ', w.name, ' ', w.fathers_name, ' (', w.title, ')')"
            ])
            ->alias('m')
            ->leftJoin(['h' => Person::tableName()], 'h.id = m.husband_id')
            ->leftJoin(['w' => Person::tableName()], 'w.id = m.wife_id')
            ->where(['OR',
                ['like', 'h.title', $text],
                ['like', 'h.name', $text],
                ['like', 'h.surname', $text],
                ['like', 'h.fathers_name', $text],
                ['like', 'w.title', $text],
                ['like', 'w.name', $text],
                ['like', 'w.surname', $text],
                ['like', 'w.fathers_name', $text],
            ])
            ->asArray()
            ->all();
        return ['results' => $authorities];
    }
}
