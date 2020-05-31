<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Carousel;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \common\models\Blog */
/* @var $displayComment [] */
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Blog'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', $model->title)];

?>
    <h3><?php echo $model->user->getFullName(); ?>'s blog</h3>

    <div class="user-view">


    <div class="well">
        <div class="media">
            <p class="pull-left">
                <img class="media-object" height="150" width="150" src="<?php echo $model->getImage(); ?>">
            </p>
            <div class="media-body">
                <p class="media-heading text-justify"><?php echo $model->description; ?></p>
            </div>
        </div>
    </div>

<?php
$images = [];

for ($i = 0; $i < sizeof($model->blogAttachments); $i++) {
    $src = $model->blogAttachments[$i]->getAttachment();
    $images[$i] = yii\bootstrap\Html::img($src, ['style' => ['height' => '300px', 'margin' => 'auto']]);
}
?>
<?php echo Carousel::widget([
    'items' => $images,
    'options' => [
        'class' => 'slide',
    ],
]); ?>

<?php if (!Yii::$app->user->isGuest): ?>
    <?php $form = ActiveForm::begin(
        ['action' => 'get-comment-post']
    ); ?>

    <?php echo $form->field($comment, 'comment')->textarea(['rows' => '5', 'style' => 'resize:none']) ?>

    <?php echo $form->field($comment, 'blog_id')->hiddenInput([
        'value' => $model->id,
    ])->label(false);

    ?>

    <div class="form-group">
        <?php echo Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
<?php endif; ?>

<?php echo $this->render('_comment', ['displayComment' => $displayComment]); ?>