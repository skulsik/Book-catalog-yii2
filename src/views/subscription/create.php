<h1>Подписка на автора</h1>
<form method="post">
    Автор:
    <select name="author_id">
        <?php foreach($authors as $a): ?>
            <option value="<?= $a->id ?>"><?= $a->full_name ?></option>
        <?php endforeach; ?>
    </select>
    <br>
    Телефон: <input type="text" name="phone">
    <br>
    <button type="submit">Подписаться</button>
</form>