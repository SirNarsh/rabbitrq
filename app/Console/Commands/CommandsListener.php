<?php

namespace App\Console\Commands;

use App\Services\ExchangeService;
use App\Services\MessageService;
use App\Services\MessagingAmqpService;
use Illuminate\Console\Command;

class CommandsListener extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:CommandsListener';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start listening & processing commands from commands queue';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        MessagingAmqpService::declareSysQueues();
        ExchangeService::bindAllExchanges();
        MessagingAmqpService::listen(
            config('amqp.commands_queue'),
            [ MessageService::class, 'consumeLog' ]
        );
    }
}
