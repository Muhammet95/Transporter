<?php

namespace App\Services\CompanyDataSyncronize;

use App\Models\Company;
use App\Models\City;
use App\Models\Transportation;
use App\Services\Dadata\GetCityByKladrService;
use Exception;
use Illuminate\Support\Facades\Log;

class BaseService
{
    public $company_name;
    public $collected_data;
    public $city_finder_service;

    public function refresh_transportations()
    {
        try {
            $this->city_finder_service = new GetCityByKladrService();
            Log::debug("Company name: " . $this->company_name);
            $company = Company::where('name', $this->company_name)->first();
            if (!$company)
                $company = Company::create([
                    'name' => $this->company_name
                ]);

            Transportation::where('company_id', $company->id)
                ->delete();

            foreach ($this->collected_data as $transportation_data) {
                if (!$this->validate_data($transportation_data))
                    continue;
                Log::debug("validation checked successfully");

                $source_city = City::where('kladr_code', $transportation_data['sourceKladr'])->first();
                if (!$source_city) {
                    $city_name = $this->city_finder_service->get($transportation_data['sourceKladr']);
                    Log::debug("finded source city name: " . $city_name);
                    if (empty($city_name))
                        continue;
                    $source_city = City::create([
                        'city_name' => $city_name,
                        'kladr_code' => $transportation_data['sourceKladr']
                    ]);
                }

                $target_city = City::where('kladr_code', $transportation_data['targetKladr'])->first();
                if (!$target_city) {
                    $city_name = $this->city_finder_service->get($transportation_data['targetKladr']);
                    Log::debug("finded target city name: " . $city_name);
                    if (empty($city_name))
                        continue;
                    $target_city = City::create([
                        'city_name' => $city_name,
                        'kladr_code' => $transportation_data['targetKladr']
                    ]);
                }

                Transportation::create([
                    'company_id' => $company->id,
                    'source_city' => $source_city->id,
                    'target_city' => $target_city->id,
                    'base_url' => $transportation_data['base_url'],
                    'type' => $transportation_data['type'],
                    'weight' => $transportation_data['weight'],
                    'error' => $transportation_data['error'],
                    'price' => ($transportation_data['type'] === 'express') ? $transportation_data['price'] : 150,
                    'coefficient' => ($transportation_data['type'] === 'express') ? 1 : $transportation_data['coefficient'],
                    'period' => ($transportation_data['type'] === 'express') ? $transportation_data['period'] : null,
                    'date' => ($transportation_data['type'] === 'express') ? null : $transportation_data['date']
                ]);
            }
        } catch (Exception $exception) {
            Log::error("Error in CompanyDataSyncronize/BaseService: " . $exception->getMessage());
            Log::error("Error in CompanyDataSyncronize/BaseService: " . $exception->getTraceAsString());
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    protected function validate_data(&$transportation_data): bool
    {
        Log::debug(json_encode($transportation_data));
        if (empty($transportation_data['sourceKladr'])
            || empty($transportation_data['targetKladr'])
            || empty($transportation_data['base_url'])
            || empty($transportation_data['type'])
            || empty($transportation_data['weight']))
            return false;

        if ($transportation_data['type'] === 'express' &&
            (empty($transportation_data['price']) || empty($transportation_data['period'])))
            return false;

        if ($transportation_data['type'] === 'normal' &&
            (empty($transportation_data['coefficient']) || empty($transportation_data['date'])))
            return false;

        return true;
    }
}
