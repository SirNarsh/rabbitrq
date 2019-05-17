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
            $Exchange = Exchange::updateOrCreate(
                ['exchange_name' => $exchangeInfo['name']],
                [
                    'type' => $exchangeInfo['type'],
                    'last_seen' => Carbon::now(),
                    'is_ignored' => $exchangeInfo['internal'],
                ]
            );
            // @todo Dispatch rebind job.
        }
    }


    /**
     * Bind all active exchange points
     */
    public static function bindAllExchanges() {
        foreach(Exchange::where('is_ignored', '=', 0)->all() as $thisExchange) {
            MessagingAmqpService::bindExchange($thisExchange->exchange_name);
        }
        // @todo Should we also send unbind for ignored exchanges?
    }
}