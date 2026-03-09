<?php

namespace app\services;

use Yii;
use yii\httpclient\Client;

/**
 * Сервис для отправки SMS
 */
class SmsService
{
    /**
     * @var string $apiKey - секретный ключ
     */
    private string $apiKey;

    /**
     * SmsService constructor.
     *
     * Берёт API-ключ из параметров приложения.
     */
    public function __construct()
    {
        $this->apiKey = Yii::$app->params['smsApiKey'] ?? '';
        if (!$this->apiKey) {
            throw new \RuntimeException('Ключ API SMS не настроен в параметрах.');
        }
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
