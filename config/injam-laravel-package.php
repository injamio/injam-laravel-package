<?php

return [


    /*
    |--------------------------------------------------------------------------
    | Injam.io default api address
    |--------------------------------------------------------------------------
    |
    |  Default api address
    |
    */

    'api_address' => env('INJAM_API_ADDRESS', 'https://api.injam.io/v1/'),

    /*
    |--------------------------------------------------------------------------
    | Injam.io API KEY
    |--------------------------------------------------------------------------
    |
    |  A valid API key is required.
    |  You can obtain your injam.io API key in your panel
    |
    |
    */

    'api_key' => env('INJAM_API_KEY'),


    /*
    |--------------------------------------------------------------------------
    | Http Request Timeout
    |--------------------------------------------------------------------------
    |
    |  Default http request timeout in seconds
    |  You can set any number. The default is 2.0
    |
    */

    'http_request_timeout' => env('INJAM_HTTP_TIMEOUT', 2.0),

];
