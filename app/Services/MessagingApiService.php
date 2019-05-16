<?php

namespace  App\Services;

use GuzzleHttp\Client;

/**
 * Class MessagingApiService
 * Communicate with RabbitMQ through management API
 * @package App\Services
 */
class MessagingApiService
{
    /**
     * @param $path
     * @return bool|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function get($path) {
        $client = new Client();
        $res = $client->request('GET', config('amqp.api') . '/api/' . $path, [
            'auth' => [
                config('amqp.user'),
                config('amqp.pass')
            ]
        ]);
        if($res->getStatusCode() !== 200) {
            return false;
        }
        return json_decode($res->getBody(), true);
    }


    /**
     * @return bool|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function getExchanges()
    {
       return self::get('exchanges');
    }
}