<?php
use yii\helpers\Html;

/** @var \app\models\Author[] $authors */
?>

<h1>Список авторов</h1>

<?php if (!Yii::$app->user->isGuest): ?>
    <p>
        <?= Html::a('Создать автора', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>
<?php endif; ?>

<table class="table table-bordered">
    <thead>
    <tr>
        <th>ID</th>
        <th>ФИО</th>
        <th>Действия</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($authors as $author): ?>
        <tr>
            <td><?= $author->id ?></td>
            <td><?= htmlspecialchars($author->full_name, ENT_QUOTES, 'UTF-8') ?></td>
            <td>
                <?php if (!Yii::$app->user->isGuest): ?>
                    <?= Html::a('Редактировать', ['update', 'id' => $author->id], ['class' => 'btn btn-sm btn-warning']) ?>
                    <?= Html::a('Удалить', ['delete', 'id' => $author->id], [
                        'class' => 'btn btn-sm btn-danger',
                        'data' => [
                            'confirm' => 'Вы уверены, что хотите удалить автора?',
                            'method' => 'post',
                        ],
                    ]) ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>