<?php

namespace app\services;

use app\models\Subscription;

/**
 * Сервис для работы с подписками на авторов
 */
class SubscriptionService
{
    /**
     * @var SmsService Сервис для отправки SMS
     */
    private SmsService $sms;

    /**
     * SubscriptionService constructor.
     *
     * @param SmsService $sms Сервис для SMS
     */
    public function __construct(SmsService $sms)
    {
        $this->sms = $sms;
    }

    /**
     * Создание подписки на автора
     *
     * @param int $authorId Идентификатор автора
     * @param string $phone Телефон подписчика
     * @return bool Успешность сохранения
     */
    public function subscribe(int $authorId, string $phone): bool
    {
        $subscription = new Subscription();
        $subscription['author_id'] = $authorId;
        $subscription['phone'] = $phone;
        $subscription['created_at'] = time();

        return $subscription->save();
    }

    /**
     * Уведомление всех подписчиков автора о новой книге
     *
     * @param int $authorId Идентификатор автора
     * @param string $bookTitle Название новой книги
     */
    public function notifyNewBook(int $authorId,string $bookTitle): void
    {
        $subs = Subscription::find()->where(['author_id' => $authorId])->all();

        foreach($subs as $sub)
        {
            $this->sms->send($sub->phone,"Новая книга: $bookTitle");
        }
    }
}
