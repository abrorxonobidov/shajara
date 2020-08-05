<?php

namespace frontend\controllers;

use common\models\person\Person;
use Yii;
use common\models\marriage\Marriage;
use common\models\marriage\MarriageSearch;
use yii\filters\AjaxFilter;
use yii\filters\ContentNegotiator;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * MarriageController implements the CRUD actions for Marriage model.
 */
class MarriageController extends BaseController
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
            'class' => ContentNegotiator::class,
            'only' => ['get-person'],
            'formats' => ['application/json' => Response::FORMAT_JSON]
        ];

        $behaviour[] = [
            'class' => AjaxFilter::class,
            'only' => ['get-person'],
            'errorMessage' => 'Sahifa topilmadi'
        ];

        return $behaviour;
    }

    /**
     * Lists all Marriage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MarriageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Marriage model.
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
     * Creates a new Marriage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Marriage();
        $model->loadDefaultValues();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Marriage model.
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
     * Deletes an existing Marriage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException | mixed if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Marriage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Marriage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Marriage::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param string $text
     * @param integer $gender_id
     * @return mixed
     */
    public function actionGetPerson($text, $gender_id = null)
    {
        if ($text === false) return Json::encode(['results' => ['id' => '', 'text' => '']]);

        $authorities = Person::find()
            ->select([
                'id',
                'text' => "CONCAT(surname, ' ', name, ' ', fathers_name, ' (', title, ')')"
            ])
            ->where(['like', "CONCAT(surname, name, fathers_name, '(', REPLACE(title, ' ', ''), ')')", str_replace([' ', '-'], '', $text)])
            ->andFilterWhere(['gender_id' => $gender_id])
            ->asArray()
            ->all();
        return ['results' => $authorities];
    }
}
