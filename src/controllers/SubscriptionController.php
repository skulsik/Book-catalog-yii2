<?php

namespace app\controllers;

use app\services\SubscriptionService;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class SubscriptionController extends Controller
{
    /**
     * @var SubscriptionService $service
     */
    private SubscriptionService $service;

    public function __construct($id, $module, SubscriptionService $service, $config = [])
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
}