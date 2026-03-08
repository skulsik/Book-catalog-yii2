<h1>Книги</h1>
<table border="1">
    <tr><th>Название</th><th>Год</th><th>Авторы</th></tr>
    <?php foreach($books as $b): ?>
        <tr>
            <td><?= $b->title ?></td>
            <td><?= $b->year ?></td>
            <td><?= implode(', ',array_map(fn($a)=>$a->full_name,$b->authors)) ?></td>
        </tr>
    <?php endforeach; ?>
</table>