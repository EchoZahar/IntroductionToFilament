<?php

namespace App\Methods\Portal;

use App\Traits\HttpClient\HandleResponseTrait;
use \Illuminate\Support\Facades\Http;

class GetPortalContextMethod
{
    use HandleResponseTrait;

    public function method(string $hash): mixed
    {
        $response = Http::get('https://abstd.ru/api-get_user_context?auth=' . $hash . '&format=json');
        return $this->handleResponse($response);
    }
}
