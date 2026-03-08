<h1>Топ авторов за <?= $year ?> год</h1>
<table border="1">
    <tr><th>Автор</th><th>Книг</th></tr>
    <?php foreach($authors as $a): ?>
        <tr>
            <td><?= $a['full_name'] ?></td>
            <td><?= $a['books_count'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>