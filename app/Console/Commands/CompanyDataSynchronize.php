<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mockery\Exception;
use Illuminate\Support\Facades\Log;
class CompanyDataSynchronize extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'synchronize:company_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';
    protected $service_list = [
        'App\Services\CompanyDataSyncronize\SibirLogistic',
        'App\Services\CompanyDataSyncronize\WorldLogistic',
        'App\Services\CompanyDataSyncronize\DHL'
    ];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            foreach ($this->service_list as $service) {
                Log::debug($service);
                (new $service())->refresh_transportations();
            }

            return Command::SUCCESS;
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }
}
