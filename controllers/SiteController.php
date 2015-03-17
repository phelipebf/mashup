<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Usuario;
use app\models\User;

class SiteController extends Controller
{
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
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successAuthCallback'],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
//        if ($model->load(Yii::$app->request->post()) && $model->login()) {
//            return $this->goBack();
//        } else {
//            return $this->render('login', [
//                'model' => $model,
//            ]);
//        }
        
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLoginFacebook()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContato()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionSobre()
    {
        return $this->render('about');
    }
    
    public function actionGaleria()
    {
        return $this->render('galeria');
    }
    
    public function actionFaq()
    {
        return $this->render('faq');
    }
    
    public function actionComoFunciona()
    {
        return $this->render('como-funciona');
    }
    
    public function actionSignUp()
    {
        return $this->render('sign-up');
    }
    
    public function successAuthCallback($client)
    {   
        $login = new LoginForm;        
        $usuario = new Usuario;
                
        $attributes = $client->getUserAttributes();
        
        $user = $usuario->findOne([
            "id_facebook" => $attributes['id'],
        ]);
                                
        if( ! isset( $user->id_facebook ) )
        {            
            $usuario->createUser( $attributes );
        }
        
        #User::setUser($attributes['id']);
        $login->username = $user->ds_email;        
        $login->login();
        
        // user login or signup comes here
    }
}
