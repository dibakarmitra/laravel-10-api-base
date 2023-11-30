<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Routing\ResponseFactory;

class ApiResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $response = app(ResponseFactory::class);

        $response->json()->macro('success', function ($statusCode, $statusMessage, $data = null) use ($response) {
            $responseData = [
                'success' => true,
                'statusCode' => $statusCode,
                'statusMessage' => $statusMessage,
                'data' => $data,
                'responseTime' => time(),
            ];

            return $response->json($responseData, $statusCode);
        });

        $response->json()->macro('error', function ($statusCode, $statusMessage, $errors) use ($response) {

            if (is_string($errors)) {
                return $response->json([
                    'success' => false,
                    'statusCode' => $statusCode,
                    'statusMessage' => $statusMessage,
                    'errors' => [$errors],
                    'responseTime' => time(),
                ], $statusCode);
            }

            $flatten = [];
            array_walk_recursive($errors, function ($error) use (&$flatten) {
                $flatten[] = $error;
            });

            return $response->json([
                'success' => false,
                'statusCode' => $statusCode,
                'statusMessage' => $statusMessage,
                'errors' => $statusCode === 422 ? $errors : $flatten,
                'responseTime' => time(),
            ], $statusCode);
        });
    }

}