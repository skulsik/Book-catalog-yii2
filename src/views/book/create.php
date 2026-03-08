<?php
/** @var \app\models\Book $book */
/** @var \app\models\Author[] $allAuthors */
?>

    <h1>Создать книгу</h1>

<?php $form = \yii\widgets\ActiveForm::begin(); ?>

<?= $form->field($book, 'title') ?>
<?= $form->field($book, 'year') ?>
<?= $form->field($book, 'description')->textarea() ?>
<?= $form->field($book, 'isbn') ?>
<?= $form->field($book, 'cover_image') ?>

    <h3>Авторы</h3>
<?php foreach ($allAuthors as $author): ?>
    <label>
        <input type="checkbox" name="authors[]" value="<?= $author->id ?>">
        <?= $author->full_name ?>
    </label><br>
<?php endforeach; ?>

    <button type="submit">Сохранить</button>

<?php \yii\widgets\ActiveForm::end(); ?>