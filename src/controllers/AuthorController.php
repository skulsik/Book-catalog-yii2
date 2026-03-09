<?php

namespace app\controllers;

use app\models\Author;
use app\repositories\AuthorRepository;
use Yii;
use yii\base\Module;
use yii\base\Response;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Контроллер для работы с авторами
 *
 * @package app\controllers
 */
class AuthorController extends Controller
{
    private AuthorRepository $repo;

    /**
     * AuthorController constructor.
     *
     * @param string $id
     * @param Module $module
     * @param AuthorRepository $repo
     * @param array $config
     */
    public function __construct(string $id, Module $module, AuthorRepository $repo, array $config = [])
    {
        $this->repo = $repo;
        parent::__construct($id, $module, $config);
    }

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
                    ['allow' => true, 'roles' => ['?', '@'], 'actions' => ['index', 'top']],
                ]
            ]
        ];
    }

    /**
     * Главная, список авторов
     *
     * @return string
     */
    public function actionIndex(): string
    {
        /** @var Author[] $authors */
        $authors = Author::find()->all();

        return $this->render('index', ['authors' => $authors]);
    }

    /**
     * Топ 10 авторов
     *
     * @param int|string $year Год
     * @return string
     */
    public function actionTop(int|string $year): string
    {
        /** @var Author[] $topAuthors */
        $topAuthors = $this->repo->getTopAuthorsByYear($year);

        return $this->render('top', ['authors' => $topAuthors, 'year' => $year]);
    }


    /**
     * Создание автора
     *
     * @return Response|string
     */
    public function actionCreate(): Response|string
    {
        $author = new Author();

        if ($author->load(Yii::$app->request->post()) && $author->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', ['author' => $author]);
    }

    /**
     * Удаление автора
     *
     * @param int $id
     * @return Response
     */
    public function actionDelete(int $id): Response
    {
        $author = Author::findOne($id);
        if ($author) {
            $author->delete();
            Yii::$app->session->setFlash('success', 'Автор удалён');
        } else {
            Yii::$app->session->setFlash('error', 'Автор не найден');
        }

        return $this->redirect(['index']);
    }
}
