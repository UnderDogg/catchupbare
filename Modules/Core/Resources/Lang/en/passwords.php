<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Password Reminder Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are the default lines which match reasons
    | that are given by the password broker for a password update attempt
    | has failed, such as for an invalid token or invalid new password.
    |
    */

    'password'  => 'Passwords must be at least six characters and match the confirmation.',
    'staff'      => "We can't find a staff with that e-mail address.",
    'token'     => 'This password reset token is invalid.',
    'sent'      => 'We have e-mailed your password reset link!',
    'reset'     => 'Your password has been reset!',
    'auth_type' => 'Only staff of type internal can reset their password! Reset your password with your authentication provider',

    'audit-log'           => [
        'category'              => 'Password reset',
        'msg-request-reset'     => 'Request reset for staff: :email.',
        'msg-reset-password'    => 'Password has been reset: :email.'
    ],


];
