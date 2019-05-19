<?php

namespace App\Console\Commands;

use App\Services\MessageService;
use App\Services\MessagingAmqpService;
use Illuminate\Console\Command;

class LogListener extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:LogListener';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start listening & logging messages on log queue';

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
        MessagingAmqpService::listen(
            config_path('amqp.log_queue'),
            [ MessageService::class, 'consumeLog' ]
        );
    }
}
