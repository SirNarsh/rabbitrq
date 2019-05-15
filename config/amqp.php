<?php

return [
    // Host info
    'host' => env('AMQP_HOST'),
    'user' => env('AMQP_USER'),
    'pass' => env('AMQP_PASS'),
    'vhost' => env('AMQP_VHOST'),

    // Queue name to bind to all exchanges in order to let rabbitrq gets all messages
    'queue_name' => env('rabbitrq.main'),
];
