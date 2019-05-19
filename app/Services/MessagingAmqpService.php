<?php

namespace  App\Services;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class MessagingAmqpService
{
    /**
     * @var AMQPStreamConnection?
     */
    static $connection ;
    /**
     * @var AMQPChannel
     */
    static $channel;

    /**
     * @return AMQPStreamConnection
     */
    public static function getConnection(): AMQPStreamConnection {
        if(!self::$connection) {
            self::$connection = new AMQPStreamConnection(
                config('amqp.host'),
                config('amqp.port'),
                config('amqp.user'),
                config('amqp.pass'),
                config('amqp.vhost')
            );
        }
        return self::$connection;
    }

    /**
     * @return AMQPChannel
     */
    public static function getChannel(): AMQPChannel {
        if(!self::$channel) {
            self::$channel = self::getConnection()->channel();
        }
        return self::$channel;
    }


    /**
     *  Declare sys queues log & commands ( You'll still need to run ExchangeService::bindAllExchanges() )
     * @return void
     */
    public static function declareSysQueues(): void {
        self::getChannel()->queue_declare(config('ampq.log_queue'), false, true);
        self::getChannel()->queue_declare(config('ampq.commands_queue'), false, true);
    }

    /**
     *  Bind rabbitrq log_queue to exchange (So we can start logging messages)
     * @param $exchange
     * @return mixed|null
     */
    public static function bindExchange(string $exchange) {
        return self::getChannel()->exchange_bind(
            config('amqp.log_queue'),
            $exchange
        );
    }

    /**
     *  Basic send message implementation
     * @param AMQPMessage $message
     * @param $queue
     */
    public static function sendMessage(AMQPMessage $message, string $queue): void {
        return self::getChannel()->basic_publish(
            $message,
            '',
            $queue
        );
    }

    /**
     *  Unbind rabbitrq log_queue from exchange (Stop logging what we don't care about)
     * @param $exchange
     * @return mixed
     */
    public static function unbindExchange(string $exchange) {
        return self::getChannel()->exchange_unbind(
            config('amqp.log_queue'),
            $exchange
        );
    }
}