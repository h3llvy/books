<?php

namespace app\services;

use Yii;
use yii\httpclient\Client;

class SendSmsService
{
    public function __construct(
        private Client $client
    )
    {
    }

    public function send(array $phones, string $text): void
    {
        $this->client->post(
            'https://smspilot.ru/api2.php',
            json_encode(
                [
                    'send' => array_map(fn($e) => ['to' => $e, 'text' => $text], $phones),
                    'apikey' => Yii::$app->params['apiKeySms'],
                ]),
            ['Content-Type' => 'application/json; charset=utf-8']

        )->send();
    }
}