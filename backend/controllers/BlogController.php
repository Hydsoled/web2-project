<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2/14/19
 * Time: 4:17 PM
 */

namespace backend\controllers;


use common\models\Blog;
use common\models\BlogAttachment;
use common\models\BlogSearch;
use trntv\filekit\actions\DeleteAction;
use trntv\filekit\actions\UploadAction;
use Yii;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\web\Controller;

class BlogController extends Controller
{

    public function actions()
    {
        return [
            'image-upload' => [
                'class' => UploadAction::class,
                'deleteRoute' => 'image-delete',
            ],
            'image-delete' => [
                'class' => DeleteAction::class
            ],
            'attachment-upload' => [
                'class' => UploadAction::class,
                'deleteRoute' => 'attachment-delete',
            ],
            'attachment-delete' => [
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
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new BlogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionCreate()
    {
        $model = new Blog();
        $post = Yii::$app->request->post();

        if ($model->load($post) && $model->save()) {
            return $this->redirect('/blog/index');
        }

        return $this->render("create", ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = Blog::findOne(['id' => $id]);
        $attachment = BlogAttachment::findOne(['blog_id' => $id]);

        if ($attachment && !$attachment->delete()) {
        }

        if (!$model->delete()) {
            throw new Exception('can not save, we are sorry about that');
        }
        return $this->redirect('/blog/index');

    }


    /** @var Blog $blog */

    public function actionUpdate($id)
    {
        $post = Yii::$app->request->post();
        $blog = Blog::findOne($id);
        if ($blog->load($post) && $blog->save()) {
            return $this->redirect('/blog/index');
        }

        return $this->render('create', ['model' => $blog]);
    }

    public function actionView($id)
    {
        $attachment = BlogAttachment::findAll(["blog_id" => $id]);
        $model = Blog::findOne($id);
        return $this->render("view", ['model' => $model, 'attachment' => $attachment]);
    }
}