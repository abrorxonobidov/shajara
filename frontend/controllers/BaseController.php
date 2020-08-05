<?php
/**
 * Created by PhpStorm.
 * User: Abrorxon Obidov
 * Date: 05-Aug-20
 * Time: 23:30
 */

namespace frontend\controllers;


use yii\filters\AccessControl;
use yii\web\Controller;

class BaseController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviour = parent::behaviors();

        $behaviour['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];

        return $behaviour;
    }

}