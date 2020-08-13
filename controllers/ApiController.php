<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use app\models\Notif;
use app\models\User;

/**
 * PeriodeController implements the CRUD actions for Periode model.
 */
class ApiController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Periode models.
     * @return mixed
     */
    public function actionRead(){
        $id = Yii::$app->user->getId();
        $role = Yii::$app->session->get('role');
        $employeeid = Yii::$app->session->has('employeeid')?Yii::$app->session->get('employeeid'):null;
        if($role=='user'){
            $model = Notif::updateAll(['Read' => 1], ['and', 
                                        ['To' => $employeeid], 
                                        ['TypeTo'=>0] 
                                    ]);
        }else{
            $model = Notif::updateAll(['Read' => 1], ['and', 
                                        ['To' => $id], 
                                        ['TypeTo'=>1] 
                                    ]);
        }
        echo true;
    }
}
