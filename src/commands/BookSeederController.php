<?php
namespace app\commands;

use yii\console\Controller;
use app\models\Book;
use app\models\Author;
use Faker\Factory;

/**
 * Консольная команда для создания тестовых книг
 *
 * php yii book-seeder/run
 */
class BookSeederController extends Controller
{
    /**
     * Создаёт 20 книг с авторами
     */
    public function actionRun(): void
    {
        $faker = Factory::create('ru_RU');

        $authors = Author::find()->all();
        $authorIds = array_map(fn($a) => $a->id, $authors);

        if (empty($authorIds)) {
            echo "Нет авторов в базе. Сначала создайте авторов.\n";
            return;
        }

        for ($i = 1; $i <= 20; $i++) {
            $book = new Book();
            $book->title = $faker->sentence(3);
            $book->year = $faker->numberBetween(1990, 2026);
            $book->description = $faker->paragraph();
            $book->isbn = $faker->unique()->isbn13;

            if ($book->save()) {
                $numAuthors = rand(1, 3);
                $selectedAuthorIds = $faker->randomElements($authorIds, $numAuthors);
                foreach ($selectedAuthorIds as $authorId) {
                    $book->link('authors', Author::findOne($authorId));
                }

                echo "Создана книга #{$i}: {$book->title} (авторов: {$numAuthors})\n";
            } else {
                echo "Ошибка при создании книги #{$i}\n";
                foreach ($book->getErrors() as $errors) {
                    foreach ($errors as $error) {
                        echo $error . "\n";
                    }
                }
            }
        }

        echo "Сидирование книг завершено.\n";
    }
}
