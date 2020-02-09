<?php

namespace Cuttle;

use Illuminate\Support\ServiceProvider;

class CuttleServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/cuttle.php' => config_path('cuttle.php'),
        ]);
    }
}
