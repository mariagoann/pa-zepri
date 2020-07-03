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
                $employeeid = null;
                if($personalinfo->employments!=null){
                    $isSuperior = $personalinfo->employments->EmployeeSuperiorID==null?true:false;
                    $employeeid = $personalinfo->employments->EmployeeID;
                }
                Yii::$app->session->set('fullname',$personalinfo->FullName);
                Yii::$app->session->set('isSuperior',$isSuperior);
                Yii::$app->session->set('employeeid',$employeeid);
            }
            if($user->role=='admin'){
                return $this->redirect(['personalinfo/index']);
            }else{
                return $this->redirect(['periode/hasil-penilaian']);
            }
            // return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
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
