<?php

namespace app\controllers;

use app\models\Author;
use app\repositories\AuthorRepository;
use yii\web\Controller;

class AuthorController extends Controller
{
    private AuthorRepository $repo;

    public function __construct(int $id, $module, AuthorRepository $repo, array $config = [])
    {
        $this->repo = $repo;
        parent::__construct($id, $module, $config);
    }

    /**
     * Главная, список авторов
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $authors = Author::find()->all();

        return $this->render('index', ['authors' => $authors]);
    }

    /**
     * Топ 10 авторов
     *
     * @return string
     */
    public function actionTop($year): string
    {
        $topAuthors = $this->repo->getTopAuthorsByYear($year);

        return $this->render('top', ['authors' => $topAuthors, 'year' => $year]);
    }
}