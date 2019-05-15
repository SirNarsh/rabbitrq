<?php

namespace  App\Services;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class MessagingAmqpService
{
    static $connection ;
    static $channel;

    public static function getConnection() {
        if(!self::$connection) {
            self::$connection = new AMQPStreamConnection(
                config('amqp.host'),
                config('amqp.user'),
                config('amqp.pass'),
                config('amqp.vhost')
            );
        }
        return self::$connection;
    }

    public static function getChannel() {
        if(!self::$channel) {
            self::$channel = self::getConnection()->channel();
        }
        return self::$channel;
    }

}