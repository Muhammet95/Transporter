<?php
namespace App\Services\CompanyDataSyncronize;
class DHL extends BaseService
{
    public function __construct()
    {
        $this->company_name = 'DHL';
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
                'weight' => 1500.0,
                'price' => 7500,
                'period' => 3,
                'error' => ''
            ],
            [
                'type' => 'express',
                'base_url' => 'https://some_url',
                'sourceKladr' => '7800000000000',
                'targetKladr' => '7700000000000',
                'weight' => 1000.0,
                'price' => 5500,
                'period' => 3,
                'error' => ''
            ],
            [
                'type' => 'normal',
                'base_url' => 'https://some_url',
                'sourceKladr' => '7700000000000',
                'targetKladr' => '7800000000000',
                'weight' => 1500.0,
                'coefficient' => 10,
                'date' => \Carbon\Carbon::now()->addMonth(),
                'error' => ''
            ],
            [
                'type' => 'normal',
                'base_url' => 'https://some_url',
                'sourceKladr' => '7800000000000',
                'targetKladr' => '7700000000000',
                'weight' => 1500.0,
                'coefficient' => 10,
                'date' => \Carbon\Carbon::now()->addMonth()->addMonth(),
                'error' => ''
            ]
        ];
    }
}
