<?php

namespace backend\controllers;

use backend\models\Note;
use backend\models\NoteSearch;
use common\models\Article;
use common\models\Blog;
use trntv\filekit\actions\DeleteAction;
use trntv\filekit\actions\UploadAction;
use Yii;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class NoteController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'create', 'update', 'delete', 'view', 'update-at-api', 'remove-from-api', 'upload-to-api', 'upload'],
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

        return $this->render("create", [
            'model' => $model,
            'mappedBlogs' => Blog::getMappedBlogs()
        ]);
    }

    public function actionUpdate($id)
    {
        $post = Yii::$app->request->post();
        $note = Note::findOne($id);
        if ($note->load($post) && $note->save()) {
            return $this->redirect('/note/index');
        }

        return $this->render('create', [
            'model' => $note,
            'mappedBlogs' => Blog::getMappedBlogs()
        ]);
    }

    public function actionDelete($id)
    {
        $model = Note::findOne(['id' => $id]);
        if (!$model->delete()) {
            throw new Exception('can not delete, we are sorry about that');
        }
        return $this->redirect('/note/index');
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
        if (!$model || $model->api_id) {
            return redirect("/note/index");
        }
        $data = [
            $model->title,
            $model->body
        ];
        $response = Note::getSendUrl('http://yii-basic.test/note-api/insert', $data);
        if (!$response->success) {
            throw new Exception('unfortunately failed');
        }

        $model->api_id = $response->id;

        if (!$model->save()) {
            throw new Exception('unfortunately failed');
        }

        return redirect("/note/index");
    }

    public function actionUpdateAtApi($id)
    {
        $model = Note::findOne($id);
        if (!$model || $model->api_id === null) return redirect("/note/index");
        $data = [
            $model->api_id,
            $model->title,
            $model->body
        ];
        $response = Note::getSendUrl('http://yii-basic.test/note-api/update', $data);

        if ($response->success) {
            echo "ქმედება წარმატებით განხორციელდა";
        } else {
            echo "ქმედება უარყოფილია";
        }
    }

    public function actionRemoveFromApi($id)
    {
        $model = Note::findOne($id);

        if (!$model || $model->api_id === null) return redirect("/note/index");

        $data = [
            $model->api_id
        ];
        $response = Note::getSendUrl('http://yii-basic.test/note-api/delete', $data);

        if (!$response->success) {
            return $this->redirect("/note/index");
        }
        $model->api_id = null;
        if (!$model->save()) {
            throw new Exception("can't save");
        }
        return $this->redirect("/note/index");
    }
}