<?php

use kartik\select2\Select2;
use trntv\filekit\widget\Upload;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>
<?php $form = ActiveForm::begin(); ?>

<?php echo $form->field($model, 'title') ?>

<?php echo $form->field($model, 'short_description') ?>

<?php echo $form->field($model, 'description')->textarea([
    'rows' => 10
]) ?>

<?php echo $form->field($model, 'image')->widget(
    Upload::class,
    [
        'url' => ['image-upload']
    ]
) ?>

<?php echo $form->field($model, 'attachment')->widget(
    Upload::class,
    [
        'url' => ['attachment-upload'],
        'sortable' => true,
        'maxNumberOfFiles' => 10,
    ]);
?>

    <div class="form-group">
        <?php echo Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>