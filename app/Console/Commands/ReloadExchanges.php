<?php

namespace App\Console\Commands;

use App\Services\ExchangeService;
use Illuminate\Console\Command;

class ReloadExchanges extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ReloadExchanges';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reload all RabbitMQ Exchanges from management API';

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
        ExchangeService::reloadExchanges();
    }
}
