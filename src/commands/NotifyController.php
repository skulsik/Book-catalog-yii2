<?php

namespace app\commands;

use yii\console\Controller;
use app\services\SubscriptionService;
use app\models\Book;

class NotifyController extends Controller
{
    /**
     * Отправка уведомлений о новых книгах подписчикам
     */
    public function actionNewBooks()
    {
        /** @var SubscriptionService $subService */
        $subService = \Yii::$container->get(SubscriptionService::class);

        // Находим книги, опубликованные за последние сутки
        $yesterday = strtotime('-1 day');
        $books = Book::find()->where(['>=', 'created_at', $yesterday])->all();

        foreach ($books as $book) {
            $subService->notifyNewBook($book->author_id, $book->title);
            echo "Уведомлены подписчики автора {$book->author_id} о книге {$book->title}\n";
        }
    }
}
