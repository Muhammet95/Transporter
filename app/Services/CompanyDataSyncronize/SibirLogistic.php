<?php
namespace App\Services\CompanyDataSyncronize;
use Illuminate\Support\Facades\Log;

class SibirLogistic extends BaseService
{
    public function __construct()
    {
        $this->company_name = 'SibirLogistic';
        $this->collected_data = $this->collect_data();
    }

    public function collect_data()
    {
        return [
            [
                'type' => 'express',
                'base_url' => 'https://some_url_2',
                'sourceKladr' => '7700000000000',
                'targetKladr' => '7800000000000',
                'weight' => 2000.0,
                'price' => 4000,
                'period' => 5,
                'error' => ''
            ],
            [
                'type' => 'express',
                'base_url' => 'https://some_url',
                'sourceKladr' => '7800000000000',
                'targetKladr' => '7700000000000',
                'weight' => 2000.0,
                'price' => 4000,
                'period' => 5,
                'error' => ''
            ],
            [
                'type' => 'normal',
                'base_url' => 'https://some_url',
                'sourceKladr' => '7700000000000',
                'targetKladr' => '7800000000000',
                'weight' => 2000.0,
                'coefficient' => 7,
                'date' => \Carbon\Carbon::now()->addMonth(),
                'error' => ''
            ],
            [
                'type' => 'normal',
                'base_url' => 'https://some_url',
                'sourceKladr' => '7800000000000',
                'targetKladr' => '7700000000000',
                'weight' => 2000.0,
                'coefficient' => 7,
                'date' => \Carbon\Carbon::now()->addMonth()->addMonth(),
                'error' => ''
            ]
        ];
    }
}
