<?php
namespace App\Services\CompanyDataSyncronize;
class WorldLogistic extends BaseService
{
    public function __construct()
    {
        $this->company_name = 'WorldLogistic';
        $this->collected_data = $this->collect_data();
    }

    public function collect_data()
    {
        return [
            [
                'type' => 'express',
                'base_url' => 'https://some_url',
                'sourceKladr' => '7700000000000',
                'targetKladr' => '7800000000000',
                'weight' => 1000.0,
                'price' => 5000,
                'period' => 3,
                'error' => ''
            ],
            [
                'type' => 'express',
                'base_url' => 'https://some_url',
                'sourceKladr' => '7800000000000',
                'targetKladr' => '7700000000000',
                'weight' => 1500.0,
                'price' => 7000,
                'period' => 3,
                'error' => ''
            ],
            [
                'type' => 'normal',
                'base_url' => 'https://some_url',
                'sourceKladr' => '7700000000000',
                'targetKladr' => '7800000000000',
                'weight' => 500.0,
                'coefficient' => 13,
                'date' => \Carbon\Carbon::now()->addMonth(),
                'error' => ''
            ],
            [
                'type' => 'normal',
                'base_url' => 'https://some_url',
                'sourceKladr' => '7800000000000',
                'targetKladr' => '7700000000000',
                'weight' => 500.0,
                'coefficient' => 13,
                'date' => \Carbon\Carbon::now()->addMonth()->addMonth(),
                'error' => ''
            ]
        ];
    }
}
