<?php

namespace app\services;

use app\models\Subscription;

class SubscriptionService
{
    private SmsService $sms;

    public function __construct(SmsService $sms)
    {
        $this->sms = $sms;
    }

    /**
     * Создание подписки
     *
     * @param int $authorId
     * @param string $phone
     *
     * @return bool
     */
    public function subscribe(int $authorId, string $phone): bool
    {
        $subscription = new Subscription();
        $subscription['author_id'] = $authorId;
        $subscription['phone'] = $phone;
        $subscription['created_at'] = time();

        return $subscription->save();
    }

    public function notifyNewBook(int $authorId,string $bookTitle): void
    {
        $subs = Subscription::find()->where(['author_id' => $authorId])->all();

        foreach($subs as $sub)
        {
            $this->sms->send($sub->phone,"Новая книга: $bookTitle");
        }
    }
}