<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomApiResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (!$response instanceof JsonResponse) {
            return $response;
        }

        $statusCode = $response->status();

        if ($statusCode === 204) {
            return $response;
        }

        $statusMessage = $statusCode === 422 ? 'Failed' : Response::$statusTexts[$statusCode];

        if ($statusCode === 500) {
            return $response->error($statusCode, $statusMessage, 'error.unexpected');
        }

        $data = $response->getData();

        if (isset($data->errors)) {
            return $response->error($statusCode, $statusMessage, get_object_vars((object)$data->errors));
        }

        if (isset($data->message)) {
            return $response->error($statusCode, $statusMessage, $data->message);
        }

        if (isset($data->data) && is_object($data->data)) {
            $data = get_object_vars((object)$data->data);
        }

        if ($statusCode === 422) {
            return $response->error($statusCode, $statusMessage, $data);
        }

        return $response->success($statusCode, $statusMessage, $data);
    }

}