<?php

namespace App\Services;

use PhpAmqpLib\Message\AMQPMessage;

class MessageService {

    /**
     * Consume message incoming to log queue
     * @param AMQPMessage $message
     * @return bool
     */
    public static function consumeLog(AMQPMessage $message): bool {
        // @todo consume message
        if(env('APP_DEBUG') == true){
            echo PHP_EOL . PHP_EOL .'### Got Message (consumeCommand):' . PHP_EOL;
            var_dump($message);
        }
        return true;
    }


    /**
     * Consume message incoming to commands queue
     * @param AMQPMessage $message
     * @return bool
     */
    public static function consumeCommand(AMQPMessage $message): bool {
        // @todo consume message
        if(env('APP_DEBUG') == true){
            echo PHP_EOL . PHP_EOL .'### Got Message (consumeCommand):' . PHP_EOL;
            var_dump($message);
        }
        return true;
    }
}