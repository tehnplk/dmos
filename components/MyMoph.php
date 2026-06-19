<?php

namespace app\components;

use yii\base\Component;

class MyMoph extends Component
{
    const DEFAULT_ENDPOINT = 'https://morpromt2f.moph.go.th/api/notify/send';

    public static function textMessage($text)
    {
        return [
            'type' => 'text',
            'text' => (string) $text,
        ];
    }

    public static function buttonFlexMessage($altText, $bodyText, $buttonLabel, $buttonUrl)
    {
        return [
            'type' => 'flex',
            'altText' => (string) $altText,
            'contents' => [
                'type' => 'bubble',
                'body' => [
                    'type' => 'box',
                    'layout' => 'vertical',
                    'contents' => [
                        [
                            'type' => 'text',
                            'text' => (string) $bodyText,
                            'wrap' => true,
                            'size' => 'md',
                        ],
                    ],
                ],
                'footer' => [
                    'type' => 'box',
                    'layout' => 'vertical',
                    'spacing' => 'sm',
                    'contents' => [
                        [
                            'type' => 'button',
                            'style' => 'primary',
                            'action' => [
                                'type' => 'uri',
                                'label' => (string) $buttonLabel,
                                'uri' => (string) $buttonUrl,
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    public static function payload($messages)
    {
        return [
            'messages' => array_values($messages),
        ];
    }

    public static function sendText($text)
    {
        return self::send([
            self::textMessage($text),
        ]);
    }

    public static function send($messages, $config = null)
    {
        if ($config === null) {
            $config = isset(\Yii::$app->params['mophNotify']) ? \Yii::$app->params['mophNotify'] : [];
        }
        $endpoint = empty($config['endpoint']) ? self::DEFAULT_ENDPOINT : $config['endpoint'];
        $clientKey = isset($config['clientKey']) ? $config['clientKey'] : '';
        $secretKey = isset($config['secretKey']) ? $config['secretKey'] : '';

        if ($clientKey === '' || $secretKey === '') {
            return [
                'success' => false,
                'statusCode' => null,
                'response' => null,
                'error' => 'Missing MOPH Notify clientKey or secretKey.',
            ];
        }

        $body = json_encode(self::payload($messages), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        if ($body === false) {
            return [
                'success' => false,
                'statusCode' => null,
                'response' => null,
                'error' => 'Cannot encode MOPH Notify payload.',
            ];
        }

        $ch = curl_init($endpoint);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'client-key: ' . $clientKey,
                'secret-key: ' . $secretKey,
            ],
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 30,
        ]);

        $rawResponse = curl_exec($ch);
        $curlError = curl_error($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $decodedResponse = is_string($rawResponse) ? json_decode($rawResponse, true) : null;

        return [
            'success' => $curlError === '' && $statusCode >= 200 && $statusCode < 300,
            'statusCode' => $statusCode,
            'response' => $decodedResponse === null ? $rawResponse : $decodedResponse,
            'error' => $curlError === '' ? null : $curlError,
        ];
    }
}
