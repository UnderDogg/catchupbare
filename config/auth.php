<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => 'staff',
        'passwords' => 'staff',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | here which uses session storage and the Eloquent staff provider.
    |
    | All authentication drivers have a staff provider. This defines how the
    | staff are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your staff's data.
    |
    | Supported: "session", "token"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'staff',
        ],

        'staff' => [
            'driver' => 'session',
            'provider' => 'staff',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'staff',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Staff Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a staff provider. This defines how the
    | staff are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your staff's data.
    |
    | If you have multiple staff tables or models you may configure multiple
    | sources which represent each model / table. These sources may then
    | be assigned to any extra authentication guards you have defined.
    |
    | Supported: "database", "eloquent"
    |
    */

    'providers' => [
        'staff' => [
            'driver' => 'eloquent',
            'model' => App\Staff::class,
            'table' => 'staff',

        ],

        // 'staff' => [
        //     'driver' => 'eloquent',
        //    'model' => App\Staff::class,
        //     'table' => 'staff',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | Here you may set the options for resetting passwords including the view
    | that is your password reset e-mail. You may also set the name of the
    | table that maintains all of the reset tokens for your application.
    |
    | You may specify multiple password reset configurations if you have more
    | than one staff table or model in the application and you want to have
    | separate password reset settings based on the specific staff types.
    |
    | The expire time is the number of minutes that the reset token should be
    | considered valid. This security feature keeps tokens short-lived so
    | they have less time to be guessed. You may change this as needed.
    |
    */

    'passwords' => [
        'staff' => [
            'provider' => 'staff',
            'email' => 'auth.emails.password',
            'table' => 'password_resets',
            'expire' => 60,
        ],

        'staff' => [
            'provider' => 'staff',
            'email' => 'auth.emails.password',
            'table' => 'password_resets',
            'expire' => 60,
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Default account status
    |--------------------------------------------------------------------------
    |
    | Specify if accounts are enabled as they are created when registering or
    | if they are disabled, and waiting for an staff administrator to manually
    | enable them.
    |
    */
    'enable_user_on_create' => env('AUTH.ENABLE_USER_ON_CREATE', true),


    /*
    |--------------------------------------------------------------------------
    | Email validation
    |--------------------------------------------------------------------------
    |
    | Should the system send an email to a staff, after the registration form is
    | submitted, with a validation link.
    |
    */
    'email_validation' => env('AUTH.EMAIL_VALIDATION', false),


    /*
    |--------------------------------------------------------------------------
    | Enable staff on validation
    |--------------------------------------------------------------------------
    |
    | Should the system automatically enable staff if they pass the email
    | validation test?
    |
    */
    'enable_user_on_validation' => env('AUTH.ENABLE_USER_ON_VALIDATION', false),



];