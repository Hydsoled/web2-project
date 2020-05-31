<?php

use dosamigos\datepicker\DatePicker;
use yii\helpers\Html;
use yii\grid\GridView;

?>
<div class="user2-index">

    <?php $this->title = Yii::t('backend', 'Blogs'); ?>

    <p>
        <?php echo Html::a('Create Blog', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'short_description',
            'title',
            'user_id',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => "{view}{update}{delete}",
            ],
        ],
    ]); ?>
    <?php
    $this->params['breadcrumbs'][] = ['label' => 'Blog', 'url' => ['index']];
    ?>

</div>