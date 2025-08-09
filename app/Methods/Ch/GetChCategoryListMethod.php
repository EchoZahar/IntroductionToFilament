<?php

namespace App\Methods\Ch;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Traits\HttpClient\HandleResponseTrait;


class GetChCategoryListMethod
{
    use HandleResponseTrait;

    public function method()
    {
        try {
            $response = Http::retry(3, 100)
                ->withToken(config('ch.ch_token'))
                ->get('https://api.nomenclature.absit.ru/api/getLocalCategories?only_matched=1');
            return $this->handleResponse($response);
        } catch (\Exception $e) {
            Log::error('Get ch category list error: ' . $e->getMessage() . ' Line: ' . $e->getLine() . ' ' . __METHOD__);
            return null;
        }
    }
}
