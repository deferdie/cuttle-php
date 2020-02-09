<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cuttle Application ID
    |--------------------------------------------------------------------------
    |
    | Each application created in Cuttle has its own unique ID. 
    | A default one can be set here or you can set one in the .env file
    |
    */

    'application_id' => env('CUTTLE_APPLICATION_ID', null),

    /*
    |--------------------------------------------------------------------------
    | Cuttle Application Key
    |--------------------------------------------------------------------------
    |
    | Each application created in Cuttle has its own generated Key. 
    | A default one can be set here or you can set one in the .env file
    |
    */

    'application_key' => env('CUTTLE_APPLICATION_KEY', null),

    /*
    |--------------------------------------------------------------------------
    | Cuttle Application Secret
    |--------------------------------------------------------------------------
    |
    | Each application created in Cuttle has its own generated secret. 
    | A default one can be set here or you can set one in the .env file
    |
    */

    'application_secret' => env('CUTTLE_APPLICATION_SECRET', null),
];
