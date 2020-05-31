<?php

use kartik\select2\Select2;
use trntv\filekit\widget\Upload;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>
<?php $form = ActiveForm::begin(); ?>

<?php echo $form->field($model, 'image')->widget(
    Upload::class,
    [
        'url' => ['image-upload']
    ]
) ?>

<?php echo $form->field($model, 'title') ?>

<?php
echo $form->field($model, 'tag')->widget(Select2::classname(), [
    'options' => ['placeholder' => 'Select a tag ...', 'multiple' => true],
    'pluginOptions' => [
        'tags' => true,
        'tokenSeparators' => [',', ' '],
        'maximumInputLength' => 10
    ],
])->label('Tags');
?>

<?php echo $form->field($model, 'body')->textarea([
    'rows' => 10
]) ?>

    <div class="form-group">
        <?php echo Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>