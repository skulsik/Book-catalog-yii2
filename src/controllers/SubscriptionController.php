<?php

namespace app\controllers;

use app\models\Author;
use app\services\SubscriptionService;
use Yii;
use yii\base\Module;
use yii\web\Controller;
use yii\web\Response;

/**
 * Контроллер для управления подписками
 *
 * @package app\controllers
 */
class SubscriptionController extends Controller
{
    /**
     * @var SubscriptionService $service Сервис подписок
     */
    private SubscriptionService $service;

    /**
     * SubscriptionController constructor.
     *
     * @param string $id Идентификатор контроллера
     * @param Module $module Модуль приложения
     * @param SubscriptionService $service Сервис подписок
     * @param array $config Конфигурация
     */
    public function __construct(string $id, Module $module, SubscriptionService $service, array $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    /**
     * Создание подписки
     *
     * @return Response
     */
    public function actionCreate(): Response
    {
        $post = Yii::$app->request->post();

        if ($this->service->subscribe($post['author_id'],$post['phone']))
        {
            Yii::$app->session->setFlash('success','Подписка оформлена');
        }
        else
        {
            Yii::$app->session->setFlash('error','Ошибка подписки');
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Создание подписки form
     *
     * @return string
     */
    public function actionForm(): string
    {
        $authors = Author::find()->all();

        return $this->render('subscribe-form', [
            'authors' => $authors,
        ]);
    }
}
