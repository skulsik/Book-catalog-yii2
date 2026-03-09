<?php

namespace app\commands;

use app\models\Author;
use yii\console\Controller;

/**
 * Консольная команда для заполнения таблицы авторов
 *
 * php yii author-seeder/run
 */
class AuthorSeederController extends Controller
{
    /**
     * Заполняет таблицу авторов 20 фиктивными записями
     */
    public function actionRun(): void
    {
        $faker = \Faker\Factory::create('ru_RU');

        for ($i = 1; $i <= 20; $i++) {
            $author = new Author();
            $author->full_name = $faker->name;
            if ($author->save()) {
                $this->stdout("Создан автор #{$i}: {$author->full_name}\n");
            } else {
                $this->stderr("Ошибка при создании автора #{$i}\n");
                foreach ($author->getErrors() as $errors) {
                    foreach ($errors as $error) {
                        $this->stderr($error . "\n");
                    }
                }
            }
        }

        $this->stdout("Сеанс заполнения авторов завершён.\n");
    }
}
