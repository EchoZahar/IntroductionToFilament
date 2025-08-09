<?php

namespace App\Traits\HttpClient;

use Illuminate\Container\Attributes\Log;
use \Illuminate\Http\Client\Response;

trait HandleResponseTrait
{
    /**
     * Summary of handleResponse
     * todo add handle rate limit
     * todo add rate limit to error logs
     * @param Response $response
     * @return mixed
     */
    public function handleResponse(Response $response): mixed
    {
        // Определить, имеет ли ответ код состояния >= 200 and < 300...
        if ($response->successful()) {
            return json_decode($response->body());
        }
        // Определить, имеет ли ответ код состояния >= 400...
        else if ($response->failed()) {
            dd($response->failed(), __METHOD__);
        }
        // Определить, имеет ли ответ код состояния 400 ...
        else if ($response->clientError()) {
            dd($response->clientError(), __METHOD__);
        }
        // Определить, имеет ли ответ код состояния 500 ...
        else if ($response->serverError()) {
            dd($response->serverError(), __METHOD__);
        }
        // Немедленно выполнить данную функцию обратного вызова, если произошла ошибка клиента или сервера...
        else {
            dd($response, __METHOD__);
        }
    }
}
