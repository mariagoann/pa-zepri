<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\PersonalInfo;
use app\models\User;
use app\models\Employment;
use app\models\Notif;
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $employeeid = null;
            $personalinfo = Personalinfo::find()
                                    ->where(['UserID'=>Yii::$app->user->id])
                                    ->one();
            //get user
            $id = Yii::$app->user->getId();
            $user = User::find()
                            ->where(['UserID'=>$id])
                            ->one();
            Yii::$app->session->set('role',$user->role);
            if($personalinfo!=null){
                $isSuperior=false;
                if($personalinfo->employments!=null){
                    $employeeid = $personalinfo->employments->EmployeeID;
                    $_isSuperior = Employment::find()
                                            ->where(['EmployeeSuperiorID'=>$employeeid])
                                            ->count();
                    $isSuperior = $_isSuperior!=0?true:false;
                }
                Yii::$app->session->set('fullname',$personalinfo->FullName);
                Yii::$app->session->set('isSuperior',$isSuperior);
                Yii::$app->session->set('employeeid',$employeeid);
                Yii::$app->session->set('personalid',$personalinfo->PersonalID);
                
            }
            //message
            $message = $this->getMessage($user->role,$employeeid);
            Yii::$app->session->set('message',json_encode($message));
            if($user->role=='admin'){
                return $this->redirect(['personalinfo/index']);
            }else if($user->role=='head'){
                return $this->redirect(['approval/index']);
            } else{
                return $this->redirect(['periode/hasil-penilaian']);
            }
            // return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    private function getMessage($role,$employeeid=null)
    {
        $notif = [];
        $badge = 0;
        $id = Yii::$app->user->getId();
        if($role=='user'){
            $notif = Notif::find()
                            ->where(['To'=>$employeeid,
                                    'TypeTo'=>0])
                            ->orderBy(['Created_at'=>SORT_DESC]);
            $badge = $notif->andWhere(['Read'=>0])
                            ->count();
            $notif = $notif->limit(15)
                            ->asArray()
                            ->all();
        }else{
            $notif = Notif::find()
                            ->where(['To'=>$id,
                                    'TypeTo'=>1])
                            ->orderBy(['Created_at'=>SORT_DESC]);
            $badge = $notif->andWhere(['Read'=>0])
                            ->count();
            $notif = $notif->limit(15)
                            ->asArray()
                            ->all();
        }
        return [
            'badge'=>$badge,
            'notif'=>$notif,
        ];
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        Yii::$app->session->destroy();
        return $this->goHome();
    }

    private function isSuperior($id){

    }
}
