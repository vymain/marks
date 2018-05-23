<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use backend\models\Marks;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'addmarks', 'viewmarks', 'progress', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
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
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionViewmarks()
    {
        $marks = new Marks();
        return $this->render('viewmarks', [
                'marks' => $marks,
            ]);
    }

    public function actionAddmarks()
    {
        $marks = new Marks();

        //return Yii::$app->response->redirect(Yii::$app->urlManager->createUrl(['site/progress']));

        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $subject = explode(":", $data["subject"]);
            $pupil = explode(":", $data['pupil']);
            $mark = explode(":", $data['mark']);
            $day = explode(":", $data['day']);
            $month = explode(":", $data['month']);
        
            return $marks->saveMark($_POST['pupil'], $_POST['subject'], $_POST['mark'], $_POST['day'], $_POST['month']);
        }

        return $this->render('addmarks', [
                'marks' => $marks,
            ]);
    }

    public function actionProgress()
    {
        if(\Yii::$app->user->isGuest)
            return Yii::$app->response->redirect(Yii::$app->urlManager->createUrl(['site/user/login']));

        if(\Yii::$app->user->isAdmin)
            return Yii::$app->response->redirect(Yii::$app->urlManager->createUrl(['site/addmarks?subject=1&m='.date('m')]));
        else
            return Yii::$app->response->redirect(Yii::$app->urlManager->createUrl(['site/viewmarks?subject=1&m='.date('m')]));
    }

    public function actionLogin()
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
}
