<?php
/** @var \app\models\SignupForm $model */
?>
<h1>Регистрация</h1>

<?php $form = \yii\widgets\ActiveForm::begin(); ?>

<?= $form->field($model, 'username') ?>
<?= $form->field($model, 'password')->passwordInput() ?>

<button>Регистрация</button>

<?php \yii\widgets\ActiveForm::end(); ?>
