<?php

use dosamigos\datepicker\DatePicker;
use yii\helpers\Html;
use yii\grid\GridView;

?>
<div class="user2-index">

    <p>
        <?php echo Html::a('Create Note', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'label' => 'image',
                'attribute' => 'image',
                'format' => 'html',
                'value' => function ($model) {
                    return yii\bootstrap\Html::img($model->getImage(), ['width' => '70px']);
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
            [
                'attribute' => 'created_at',
                'value' => 'created_at',
                'format' => 'date',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'created_at',
                    'template' => '{addon}{input}',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'mm/dd/yyyy'
                    ]
                ])
            ],
            [
                'attribute' => 'updated_at',
                'value' => 'updated_at',
                'format' => 'date',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'updated_at',
                    'template' => '{addon}{input}',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'mm/dd/yyyy'
                    ]
                ])
            ],
            'title',
            'body',
            'user_id',
            'api_id',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php
    $this->params['breadcrumbs'][] = ['label' => 'Note', 'url' => ['index']];
    ?>

</div>