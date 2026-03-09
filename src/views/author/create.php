<?php
/** @var \app\models\Author $author */
/** @var yii\widgets\ActiveForm $form */
?>

    <h1>Создать автора</h1>

<?php $form = \yii\widgets\ActiveForm::begin(); ?>

<?= $form->field($author, 'full_name')->textInput(['maxlength' => true]) ?>

    <button type="submit" class="btn btn-primary">Сохранить</button>

<?php \yii\widgets\ActiveForm::end(); ?>

