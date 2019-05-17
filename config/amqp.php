<?php

return [
    // Host info
    'host' => env('AMQP_HOST', 'localhost'),
    'port' => env('AMQP_PORT', '5672'),
    'api' => env('AMQP_API', 'localhost:15672'),
    'user' => env('AMQP_USER', 'guest'),
    'pass' => env('AMQP_PASS', 'guest'),
    'vhost' => env('AMQP_VHOST', '/'),

    // Queue name to bind to all exchanges in order to let rabbitrq gets all messages and log them
    'log_queue' => env('AMQP_LOG_QUEUE'),

    // Special commands queue allow remotely controlling rabbitrq microservice without direct API calls
    'commands_queue' => env('AMQP_COMMANDS_QUEUE'),
];
