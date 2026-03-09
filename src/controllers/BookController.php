<?php

namespace app\controllers;

use app\models\Author;
use app\models\Book;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Контроллер для работы с книгами
 *
 * @package app\controllers
 */
class BookController extends Controller
{
    /**
     * Настройка правил доступа
     *
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    ['allow' => true, 'roles' => ['@'], 'actions' => ['create', 'update', 'delete']],
                    ['allow' => true, 'roles' => ['?', '@'], 'actions' => ['index', 'view']],
                ]
            ]
        ];
    }

    /**
     * Главная, список книг
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $books = Book::find()->with('authors')->all();

        return $this->render('index', ['books' => $books]);
    }

    /**
     * Просмотр книги
     *
     * @param int $id
     * @return string
     */
    public function actionView(int $id): string
    {
        $book = Book::findOne($id);

        return $this->render('view', ['book' => $book]);
    }

    /**
     * Создание книги
     *
     * @return Response|string
     */
    public function actionCreate(): Response|string
    {
        $book = new Book();

        if ($book->load(Yii::$app->request->post()) && $book->save())
        {
            $authors = Yii::$app->request->post('authors', []);
            $book->unlinkAll('authors', true);

            foreach($authors as $authorId)
            {
                /** @var Author|null $author */
                $author = Author::findOne($authorId);
                if ($author !== null) {
                    $book->link('authors', $author);
                }
            }

            return $this->redirect(['view','id' => $book->id]);
        }

        /** @var Author[] $allAuthors */
        $allAuthors = Author::find()->all();

        return $this->render('create', ['book' => $book, 'allAuthors' => $allAuthors]);
    }

    /**
     * Удаление книги
     *
     * @param int $id
     * @return Response
     */
    public function actionDelete(int $id): Response
    {
        $book = Book::findOne($id);
        if ($book !== null) {
            $book->delete();
            Yii::$app->session->setFlash('success', 'Книга удалена');
        } else {
            Yii::$app->session->setFlash('error', 'Книга не найдена');
        }
        return $this->redirect(['index']);
    }
}
