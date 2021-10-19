<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('jsonError', function ($data = null) {
            $json = ['status' => 'fail'];

            if ($data) {
                $json['data'] = $data;
            }

            return response()->json($json);
        });

        Response::macro('jsonSuccess', function ($data = null) {
            $json = ['status' => 'ok'];

            if ($data) {
                $json['data'] = $data;
            }

            return response()->json($json);
        });
    }
}
