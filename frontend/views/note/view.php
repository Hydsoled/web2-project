<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ApiUsers */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Note', 'url' => ['index']];

?>
<div>

    <div style="margin-bottom: 10px">

        <?php echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

        <?php echo Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
            ],
        ]) ?>

        <?php echo Html::a(
            'Upload to API',
            ['upload-to-api', 'id' => $model->id],
            ['class' => 'btn btn-success ' . ($model->api_id ? 'disabled' : '')]
        ); ?>

        <?php echo Html::a(
            'Update at API',
            ['update-at-api', 'id' => $model->id],
            ['class' => 'btn btn-success ' . (!$model->api_id ? 'disabled' : '')]
        ) ?>
        <?php echo Html::a(
            'Remove from API',
            ['remove-from-api', 'id' => $model->id],
            ['class' => 'btn btn-success ' . (!$model->api_id ? 'disabled' : '')]
        ) ?>

    </div>
    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => 'image',
                'attribute' => 'image',
                'format' => 'html',
                'value' => function ($model){
                    return yii\bootstrap\Html::img($model->getImage(),['width' => '300px']);
                }
            ],
            [
                'label' => 'Tags',
                'attribute' => 'tag',
                'format' => 'html',
                'value' => function ($model) {
                    /** @var \frontend\models\Note $model */
                    return $model->getDisplayBadges();
                }
            ],
            'created_at:datetime',
            'updated_at:datetime',
            'body',
            'title',
            'user.username',
            'api_id:html'
        ],
    ]) ?>

</div>
