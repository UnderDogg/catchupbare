<?php

return [

    /**
     * Enables recording of exception.
     */
    'enable_record'   => env('LERN.ENABLE_RECORD', false),

    /**
     * Enables notification of exception.
     */
    'enable_notify'   => env('LERN.ENABLE_NOTIFY', false),

    'record' => [
        'table' => 'lern_exceptions',
        'collect' => [
            'method'      => true, //When true it will collect GET, POST, DELETE, PUT, etc...
            'data'        => true, //When true it will collect Input data
            'status_code' => true,
            'staff_id'     => true,
            'url'         => true,
        ],

        /**
         * When record.collect.data is true, this will exclude certain data keys recursively
         */
        'excludeKeys' => [
            'password'
        ]
    ],

    'notify' => [
        /**
         * The default name of the monolog logger channel
         */
        'channel' => env('LERN.CHANNEL', 'LESK'),

        /**
         * When using the default message body this will also include the stack trace
         */
        'includeExceptionStackTrace' => true,
        
        /**
         * mail, pushover, slack, etc...
         */
        'drivers' => ['mail'],

        /**
         * Mail settings
         */
        'mail'=>[
            'to'   => env('LERN.MAIL_RECIPIENT'),
            'from' => env('MAIL.SYSTEM_SENDER_ADDRESS'),
            'smtp' => false,
        ],

        /**
         * Mailgun settings
         */
        'mailgun' => [
            'to'     => env('MAILGUN_TO'),
            'from'   => env('MAILGUN_FROM'),
            'token'  => env('MAILGUN_APP_TOKEN'),
            'domain' => env('MAILGUN_DOMAIN'),
        ],

        /**
         * Pushover settings
         */
        'pushover' => [
            'token' => env('PUSHOVER_APP_TOKEN'),
            'staff' => env('PUSHOVER_USER_KEY'),
            'sound' => env('PUSHOVER_SOUND_ERROR', 'siren'), // https://pushover.net/api#sounds
        ],

        /**
         * Slack settings
         */
        'slack' => [
            'token'    => env('SLACK_APP_TOKEN'), //https://api.slack.com/web#auth
            'channel'  => env('SLACK_CHANNEL', '#exceptions'), //Dont forget the '#'
            'username' => env('SLACK_USERNAME', 'LERN'), //The 'from' name
        ],

        /**
         * HipChat settings
         */
        'hipchat' => [
            'token'  => env('HIPCHAT_APP_TOKEN'),
            'room'   => 'room',
            'name'   => 'name',
            'notify' => true,
        ],

        /**
         * Flowdock settings
         */
        'flowdock' => [
            'token' => env('FLOWDOCK_APP_TOKEN'),
        ],

        /**
         * Fleephook settings
         */
        'fleephook' => [
            'token' => env('FLEEPHOOK_APP_TOKEN'),
        ],

        /**
         * Plivo settings
         */
        'plivo' => [
            'auth_id' => env('PLIVO_AUTH_ID'),
            'token'   => env('PLIVO_AUTH_TOKEN'),
            'to'      => env('PLIVO_TO'),
            'from'    => env('PLIVO_FROM'),
        ],

        /**
         * Twilio settings
         */
        'twilio' => [
            'sid'    => env('TWILIO_AUTH_SID'),
            'secret' => env('TWILIO_AUTH_SECRET'),
            'to'     => env('TWILIO_TO'),
            'from'   => env('TWILIO_FROM'),
        ],

        /**
         * Raven settings
         */
        'raven' => [
            'dsn'   => env('RAVEN_DSN'),
        ]
    ],
    
];
