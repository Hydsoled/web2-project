<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Notes'), 'url' => ['note']];
$this->title = "Note". $model->id;
?>
<div class="user-view">

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
                'label' => 'Tags',
                'attribute' => 'tag',
                'format' => 'html',
                'value' => function ($model) {
                    /** @var \frontend\models\Note $model */
                    return $model->getDisplayBadges();
                }
            ],
            'created_at:date',
            'updated_at:date',
            'title',
            'body',
            'api_id'
        ],
    ]) ?>

</div>
