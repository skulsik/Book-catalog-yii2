<?php
/** @var \app\models\Book $book */
?>

    <h1><?= htmlspecialchars($book->title) ?></h1>

    <p><strong>Год:</strong> <?= $book->year ?></p>
    <p><strong>ISBN:</strong> <?= $book->isbn ?></p>
    <p><strong>Описание:</strong><br><?= nl2br(htmlspecialchars($book->description)) ?></p>

    <h3>Авторы:</h3>
    <ul>
        <?php foreach ($book->authors as $author): ?>
            <li><?= htmlspecialchars($author->full_name) ?></li>
        <?php endforeach; ?>
    </ul>

    <h3>Изображения:</h3>
<?php if (!empty($book->images)): ?>
    <?php foreach ($book->images as $image): ?>
        <img src="<?= $image->path ?>" alt="Обложка" style="max-width: 150px; margin: 5px;">
    <?php endforeach; ?>
<?php else: ?>
    <p>Нет изображений</p>
<?php endif; ?>

