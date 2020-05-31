<?php

namespace frontend\controllers;

use frontend\models\Note;
use frontend\models\NoteSearch;
use Intervention\Image\ImageManagerStatic;
use phpDocumentor\Reflection\DocBlock\Tag;
use trntv\filekit\actions\DeleteAction;
use trntv\filekit\actions\UploadAction;
use yii\web\Controller;
use Yii;
use linslin\yii2\curl;
use yii\filters\AccessControl;
use app\models\UploadForm;
use yii\web\UploadedFile;

class NoteController extends Controller
{
    public function actions()
    {
        return [
            'image-upload' => [
                'class' => UploadAction::class,
                'deleteRoute' => 'image-delete'
            ],
            'image-delete' => [
                'class' => DeleteAction::class
            ]
        ];
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'create', 'update', 'delete', 'view', 'update-at-api', 'remove-from-api', 'upload-to-api', 'upload', 'image-upload', 'image-delete'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new NoteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new Note();
        $post = Yii::$app->request->post();

        if ($model->load($post) && $model->save()) {
            return $this->redirect('/note/index');
        }

        return $this->render("create", ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = Note::findOne(['id' => $id]);
        if ($model->delete()) {
            return $this->redirect('/note/index');
        }
    }

    public function actionUpdate($id)
    {
        $post = Yii::$app->request->post();
        $note = Note::findOne($id);
        if ($note->load($post) && $note->save()) {
            return $this->redirect('/note/index');
        }

        return $this->render('create', ['model' => $note]);
    }

    public function actionView($id)
    {
        $model = Note::findOne($id);
        return $this->render("view", ['model' => $model]);
    }

    //manipulations at api

    public function actionUploadToApi($id)
    {
        $model = Note::findOne($id);
        if ($model->api_id) return redirect("/note/index");
        if ($model) {
            $data = [
                $model->title,
                $model->body
            ];
        }
        $fields_string = http_build_query($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://yii-basic.test/note-api/insert');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response);
        if ($response->success) {
            $model->api_id = $response->id;
            if ($model->save()) {
                return redirect("/note/index");
            } else return;
        } else return;
    }

    public function actionUpdateAtApi($id)
    {
        $model = Note::findOne($id);

        if ($model->api_id === null) return redirect("/note/index");

        if ($model) {
            $data = [
                $model->api_id,
                $model->title,
                $model->body
            ];
        }
        $fields_string = http_build_query($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://yii-basic.test/note-api/update');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response);
        if ($response->success) {
            echo "ქმედება წარმატებით განხორციელდა";
        } else {
            echo "ქმედება უარყოფილია";
        }
    }

    public function actionRemoveFromApi($id)
    {
        $model = Note::findOne($id);

        if ($model->api_id === null) return redirect("/note/index");

        if ($model) {
            $data = [
                $model->api_id
            ];
        }
        $fields_string = http_build_query($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://yii-basic.test/note-api/delete');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response);
        if ($response->success) {
            $model->api_id = null;
            if ($model->save()) {
                return $this->redirect("/note/index");
            } else {
                echo "ქმედება უარყოფილია";
            }
        } else {
            echo "ქმედება უარყოფილია";
        }
    }

}