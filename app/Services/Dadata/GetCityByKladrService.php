<?php

namespace App\Services\Dadata;

use Dadata\DadataClient;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

class GetCityByKladrService
{
    public function get($kaldr)
    {
        try {
            $token = "6121808a6527fd415fc82e14dd45b03aa3b256f3";
            $dadata = new DadataClient($token, null);
            $result = $dadata->findById("address", $kaldr, 1);
            return $result[0]['data']['city'];
        } catch (Exception $exception) {
            Log::error("Error on GetCityByKladrService: " . $exception->getMessage());
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }
}
