<?php

namespace app\services;

use yii\httpclient\Client;

class SmsService
{
    /**
     * @var string $apiKey - секретный ключ
     */
    private string $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Отправка сообщения пользователю на подписке
     *
     * @param string $phone
     * @param string $message
     *
     * @return bool
     */
    public function send(string $phone, string $message): bool
    {
        $client = new Client();
        $response = $client->post('https://smspilot.ru/api.php', [
            'send' => $message,
            'to' => $phone,
            'apikey' => $this->apiKey,
        ])->send();

        return $response->isOk;
    }
}