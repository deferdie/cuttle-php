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
        $loggingConfig = \Config::get('logging.channels');

        $cuttleLogger = ['cuttle' => [
            'driver' => 'monolog',
            'handler' => \Cuttle\CuttleLogHandler::class
        ]];

        $mergedConfig = array_merge($cuttleLogger, $loggingConfig);

        \Config::set('logging.channels', $mergedConfig);
    }
}
