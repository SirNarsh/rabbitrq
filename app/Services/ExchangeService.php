<?php

namespace App\Services;

use App\Exchange;
use Carbon\Carbon;

/**
 * Class ExchangeService
 * @package App\Services
 */
class ExchangeService
{
    /**
     * Reload all RabbitMQ Exchanges from management API'
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function reloadExchanges() {
        foreach(MessagingApiService::getExchanges() as $exchangeInfo) {
            // ignore anything that starts with amqp.
            if(strpos($exchangeInfo['name'],'amqp') === 0){
                continue;
            }
            // ignore default exchange
            if($exchangeInfo['name'] === ''){
                continue;
            }

            $Exchange = Exchange::updateOrCreate(
                ['exchange_name' => $exchangeInfo['name']],
                [
                    'type' => $exchangeInfo['type'],
                    'last_seen' => Carbon::now(),
                    'is_ignored' => 0,
                ]
            );
        }
        // @todo Dispatch rebind job.
    }


    /**
     * Bind all active exchange points
     */
    public static function bindAllExchanges() {
        foreach(Exchange::where('is_ignored', '=', 0)->get() as $thisExchange) {
            MessagingAmqpService::bindExchange($thisExchange->exchange_name);
        }
        // @todo Should we also send unbind for ignored exchanges?
    }
}