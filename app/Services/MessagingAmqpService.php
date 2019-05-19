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
        self::getChannel()->queue_declare(config('amqp.log_queue'), false, true,false, false);
        self::getChannel()->queue_declare(config('amqp.commands_queue'), false, true, false, false);
    }

    /**
     *  Bind rabbitrq log_queue to exchange (So we can start logging messages)
     * @param $exchange
     * @return mixed|null
     */
    public static function bindExchange(string $exchange) {
        return self::getChannel()->queue_bind(
            config('amqp.log_queue'),
            $exchange
        );
    }

    /**
     *  Basic send message implementation
     * @param AMQPMessage $message
     * @param $queue
     */
    public static function sendMessage(AMQPMessage $message, string $queue) {
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

    /**
     * Start a consumer for the queue with name, and invoke callback on messages
     * @param string $queue
     * @param callable $callback
     * @throws \ErrorException
     */
    public static function listen(string $queue, callable $callback)
    {
        self::getChannel()->basic_consume(
            $queue,
            '',
            false,
            false,
            false,
            false,
            function ($message) use ($callback) {
                if($callback($message)){
                    $message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);
                } else {
                    $message->delivery_info['channel']->basic_nack($message->delivery_info['delivery_tag']);
                }
            }
        );

        register_shutdown_function(function () { MessagingAmqpService::shutdown(); });

        // Loop as long as the channel has callbacks registered
        while (self::getChannel()->is_consuming()) {
            self::getChannel()->wait();
        }
    }

    /**
     * To be called on shutdown
     * @throws \Exception
     */
    public static function shutdown() {
        self::getChannel()->close();
        self::getConnection()->close();
    }
}