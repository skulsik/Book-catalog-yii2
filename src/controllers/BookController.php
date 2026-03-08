<?php

namespace app\controllers;

use app\models\Author;
use app\models\Book;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class BookController extends Controller
{
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
     *
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
                $book->link('authors', Author::findOne($authorId));
            }

            return $this->redirect(['view','id' => $book->id]);
        }

        $allAuthors = Author::find()->all();

        return $this->render('create', ['book' => $book, 'allAuthors' => $allAuthors]);
    }
}