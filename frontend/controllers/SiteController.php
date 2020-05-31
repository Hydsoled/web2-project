<?php

namespace frontend\controllers;

use frontend\models\Form;
use frontend\models\myUsers;
use cheatsheet\Time;
use common\sitemap\UrlsIterator;
use frontend\models\ContactForm;
use frontend\models\Indexes;
use Sitemaped\Element\Urlset\Urlset;
use Sitemaped\Sitemap;
use Yii;
use yii\base\Model;
use yii\filters\PageCache;
use yii\helpers\VarDumper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;
use linslin\yii2\curl;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => PageCache::class,
                'only' => ['sitemap'],
                'duration' => Time::SECONDS_IN_AN_HOUR,
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
            ],
            'set-locale' => [
                'class' => 'common\actions\SetLocaleAction',
                'locales' => array_keys(Yii::$app->params['availableLocales'])
            ]
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @return string|Response
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->contact(Yii::$app->params['adminEmail'])) {
                Yii::$app->getSession()->setFlash('alert', [
                    'body' => Yii::t('frontend', 'Thank you for contacting us. We will respond to you as soon as possible.'),
                    'options' => ['class' => 'alert-success']
                ]);
                return $this->refresh();
            }

            Yii::$app->getSession()->setFlash('alert', [
                'body' => \Yii::t('frontend', 'There was an error sending email.'),
                'options' => ['class' => 'alert-danger']
            ]);
        }

        return $this->render('contact', [
            'model' => $model
        ]);
    }

    /**
     * @param string $format
     * @param bool $gzip
     * @return string
     * @throws BadRequestHttpException
     */
    public function actionSitemap($format = Sitemap::FORMAT_XML, $gzip = false)
    {
        $links = new UrlsIterator();
        $sitemap = new Sitemap(new Urlset($links));

        Yii::$app->response->format = Response::FORMAT_RAW;

        if ($gzip === true) {
            Yii::$app->response->headers->add('Content-Encoding', 'gzip');
        }

        if ($format === Sitemap::FORMAT_XML) {
            Yii::$app->response->headers->add('Content-Type', 'application/xml');
            $content = $sitemap->toXmlString($gzip);
        } else if ($format === Sitemap::FORMAT_TXT) {
            Yii::$app->response->headers->add('Content-Type', 'text/plain');
            $content = $sitemap->toTxtString($gzip);
        } else {
            throw new BadRequestHttpException('Unknown format');
        }

        $linksCount = $sitemap->getCount();
        if ($linksCount > 50000) {
            Yii::warning(\sprintf('Sitemap links count is %d'), $linksCount);
        }

        return $content;
    }


    /**
     * $model IndexInsert
     * @return string
     * @throws \Throwable
     */
    public function actionFirst()
    {
        $curl = new curl\Curl();
        $response = $curl->get("http://yii-basic.test/user-api/download");
        if (!$response) {
            return;
        }

        $response = json_decode($response);
        $response = $response->message;
        $k = 0;
        foreach ($response as $item) {
            $model = myUsers::find()
                ->where(['id' => $item->id])
                ->one();

            if (!$model) {
                $model = new myUsers();
                $model->id = $item->id;
                $k++;
                echo "თქვენს ბაზაში ჩაიწერა ახალი ID: " . $item->id . "<br>";
            }

            $model->first_name = $item->first_name;
            $model->last_name = $item->last_name;
            $model->save();
        }
        if ($k === 0) echo "სამწუხაროდ ბაზაში ახალი ID არ დაემატა";
    }

    public function actionSecond()
    {
        $model = new Form();
        $post = Yii::$app->request->post();

        if ($model->load($post)) {
            $data = [
                $model->first_name,
                $model->last_name
            ];

            $fields_string = http_build_query($data);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://yii-basic.test/user-api/write');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($response);

            if ($response->success) {

                $userModel = myUsers::find()
                    ->where(['id' => $response->id])
                    ->one();

                if (!$userModel) {
                    $models = new myUsers();
                    $models->id = $response->id;
                }

                $models->first_name = $model->first_name;
                $models->last_name = $model->last_name;
                $models->save();
                echo "ყველაფერი კარგადაა";
            }

        } else {
            return $this->render('enform', ['model' => $model]);
        };
    }

    // update user

    public function actionUpdate($person_id)
    {
        $model = myUsers::findOne($person_id);
        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            $model->first_name = $post["myUsers"]['first_name'];
            $model->last_name = $post["myUsers"]['last_name'];
            $data = [
                $model->id,
                $model->first_name,
                $model->last_name
            ];

            $fields_string = http_build_query($data);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://yii-basic.test/user-api/update');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($response);

            if ($response->success) {
                $model->save();
                echo "ყველაფერი კარგადაა";
            }

        } else {
            return $this->render('update', [
                'model' => $model
            ]);
        };
    }

    public function actionDelete($person_id)
    {
        $model = myUsers::findOne($person_id);
        if ($model !== null) {
            $data = [
                $model->id
            ];

            $fields_string = http_build_query($data);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://yii-basic.test/user-api/delete');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($response);

            if ($response->success) {
                $model->delete();
                echo "ყველაფერი კარგადაა";
            } else {
                echo "API-ზე მომხმარებელი არ წაიშალა :(";
            }
        } else {
            echo "ასეთი ID-ით მომხმარებელი არ არსებობს.";
        }
    }
}
