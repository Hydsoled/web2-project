<?php

namespace frontend\controllers;

use common\models\Blog;
use common\models\BlogComment;
use common\models\BlogSearch;
use DateTime;
use DateTimeZone;
use http\Exception\BadUrlException;
use http\Exception\InvalidArgumentException;
use http\Url;
use Yii;
use yii\db\Exception;
use yii\web\Controller;

class BlogController extends Controller
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }


    public function actionIndex($index = 0, $userId = null)
    {
        $models = BlogSearch::getPaginationIndex($index, $userId);
        if ($models) {
            return $this->render('index', ['model' => $models, 'index' => $index, 'userId' => $userId]);
        }
        else {
            return $this->render('empty_blog');
        }
    }

    public function actionView($id)
    {
        $model = Blog::find()->byId($id)->one();
        if (!$model) {
            throw new \yii\console\Exception('what are you doing? are you trying to hack my blog?');
        }
        $comment = new BlogComment();
        $displayComment = BlogComment::find()->byCreateDate()->byBlogId($id)->all();

        return $this->render('view', [
            'model' => $model,
            'comment' => $comment,
            'displayComment' => $displayComment
        ]);
    }

    /**
     * @return \yii\web\Response
     * @throws \Exception
     */
    public function actionGetCommentPost()
    {
        $request = Yii::$app->request;
        if ($request->post()) {
            $id = $request->post('id');
            $blog = BlogComment::findOne(['id' => $id]);
            if (!$blog) {
                $blog = new BlogComment();
                if (!$blog->load($request->post())) {
                    throw new \Exception("can not load data");
                }
            } else {
                $blog->comment = $request->post("comment");
            }

            if (!$blog->save()) {
                throw new \Exception("can not save data");
            }
            return $this->redirect(['view', 'id' => $blog->blog_id]);
        }

        return Yii::$app->response->setStatusCode(403, 'bye');
    }

    public function actionDeleteComment()
    {
        $id = Yii::$app->request->post('id');
        if ($id) {
            $model = BlogComment::findOne(['id' => $id]);
            if ($model->delete()) {
                return 'true';
            } else {
                return "false";
            }
        }

    }
}