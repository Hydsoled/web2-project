<?php

use dosamigos\datepicker\DatePicker;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Notes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <p>
        <?php echo Html::a('Create Note', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => [
            'class' => 'grid-view table-responsive'
        ],
        'columns' => [
            'id',
            [
                'label' => 'Tags',
                'attribute' => 'tag',
                'format' => 'html',
                'value' => function ($model) {
                    return $model->getDisplayBadges();
                }
            ],
            'created_at:date',
            'updated_at:date',
            'title',
            'body',
            'user_id',
            'api_id',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => "{view}{update}{delete}",
            ],
        ],
    ]); ?>

</div>
