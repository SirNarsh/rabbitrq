<?php

return [
    // Host info
    'host' => env('AMQP_HOST', 'localhost'),
    'api' => env('AMQP_API', 'localhost'),
    'user' => env('AMQP_USER', 'guest'),
    'pass' => env('AMQP_PASS', 'guest'),
    'vhost' => env('AMQP_VHOST', ''),

    // Queue name to bind to all exchanges in order to let rabbitrq gets all messages
    'queue_name' => env('rabbitrq.main'),
];
