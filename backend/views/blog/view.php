<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Blog'), 'url' => ['blog']];
$this->title = "Blog". $model->id;
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
            'created_at:date',
            'updated_at:date',
            'title',
            'description',
        ],
    ]) ?>

    <?php echo DetailView::widget([
        'model' => $attachment,
        'attributes' => [
            [
                'label' => 'attachments',
                'attribute' => 'attachment',
                'format'=>'html',
                'value' => function ($model){
                    $attachments = '';
                    for ($i = 0; $i<sizeof($model); $i++){
                         $k = $model[$i]->getAttachment();
                         $attachments .= "<img src='$k' height='100' width='100' style='margin-left: 20px'>";
                    }
                    return $attachments;
                }
            ],
        ],
    ]) ?>
</div>
