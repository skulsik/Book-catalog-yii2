<?php
namespace app\repositories;

use yii\db\Query;

class AuthorRepository
{
    public function getTopAuthorsByYear(int $year): array
    {
        return (new Query())
            ->select(['a.full_name', 'COUNT(b.id) as books_count'])
            ->from('author a')
            ->innerJoin('book_author ba', 'ba.author_id=a.id')
            ->innerJoin('book b', 'b.id=ba.book_id')
            ->where(['b.year' => $year])
            ->groupBy('a.id')
            ->orderBy(['books_count' => SORT_DESC])
            ->limit(10)
            ->all();
    }
}