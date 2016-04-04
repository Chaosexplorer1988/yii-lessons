<?php

namespace app\controllers;

use app\models\Access;
use Yii;
use app\models\Calendar;
use app\models\search\SearchCalendar;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii2fullcalendar\models\Event;

/**
 * CalendarController implements the CRUD actions for Calendar model.
 */
class CalendarController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['mynotes', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['mynotes', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Calendar models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (\Yii::$app->user->isGuest) {
            return $this->redirect(['viewguest']);
        }
        $searchModel = new SearchCalendar();
        $dataProvider = $searchModel->search(
            [
                'SearchCalendar' =>
                  ['creator' => Yii::$app->user->id]

            ]
        );
        $e = Calendar::find()->where(['creator' => Yii::$app->user->id])->all();
        foreach ($e as $eve)
        {
            $event = new Event();
            $event->id = $eve->id;
            $event->title = $eve->text;
            $event->start = $eve->date_event;
            $event->backgroundColor = 'red';
            $events[] = $event;
        }

        if(!$e){
            $Event = new Event();
            $Event->id = 1;
            $Event->title = 'Сегодня';
            $Event->start = date('Y-m-d\TH:i:s\Z');
            $events[] = $Event;
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'creator' => Yii::$app->user->id,
            'dataProvider' => $dataProvider,
            'events' => $events
        ]);
    }

    public function actionViewguest(){
        $searchModel = new SearchCalendar();
        $dataProvider = $searchModel->search([

        ]);
        $Event = new Event();
        $Event->id = 1;
        $Event->title = 'Сегодня';
        $Event->start = date('Y-m-d\TH:i:s\Z');
        $events[] = $Event;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'events' => $events
        ]);
    }

    public function actionFriendcalendars($id){
        $searchModel = new SearchCalendar();
        $dataProvider = $searchModel->search([
            'SearchCalendar' => [
                'creator' => $id,
                'access' => [
                    'user_guest' => Yii::$app->user->id,
                ]
            ]
        ]);
        $e = Calendar::find()->select('*')
                        ->leftJoin('table_access', '`table_access`.`date` = `clndr_calendar`.`date_event`')
                        ->where(['user_guest'=>Yii::$app->user->id])
                        ->all();
        foreach ($e as $eve)
        {
            $event = new Event();
            $event->id = $eve->id;
            $event->title = $eve->text;
            $event->start = $eve->date_event;
            $event->backgroundColor = 'red';
            $events[] = $event;
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'events' => $events
        ]);
    }
    /**
     * Displays a single Calendar model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $result = Access::checkAccess($model);
        switch($result){
            case Access::ACCESS_CREATOR:
                return $this->render('viewCreator', [
                    'model' => $model,
                ]);
                break;
            case Access::ACCESS_GUEST:
                return $this->render('viewGuest', [
                    'model' => $model,
                ]);
                break;
            default:
                throw new ForbiddenHttpException("Access denied", 403);
                break;
        }
    }

    /**
     * Creates a new Calendar model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($date)
    {
        $model = new Calendar();
        $model->date_event = $date;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Calendar model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (\Yii::$app->user->isGuest) {
            return $this->redirect(['index']);
        }
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Calendar model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (\Yii::$app->user->isGuest) {
            return $this->redirect(['index']);
        }
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Calendar model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Calendar the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Calendar::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
