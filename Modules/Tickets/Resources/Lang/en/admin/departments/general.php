<?php
return [

    'audit-log'           => [
        'category'              => 'Department',
        'msg-index'             => 'Accessed list of departments.',
        'msg-show'              => 'Accessed details of departments: :username.',
        'msg-store'             => 'Created new departments: :username.',
        'msg-edit'              => 'Initiated edit of departments: :username.',
        'msg-replay-edit'       => 'Initiated replay edit of departments: :username.',
        'msg-update'            => 'Submitted edit of departments: :username.',
        'msg-destroy'           => 'Deleted departments: :username.',
        'msg-enable'            => 'Enabled departments: :username.',
        'msg-disabled'          => 'Disabled departments: :username.',
        'msg-enabled-selected'  => 'Enabled multiple departments.',
        'msg-disabled-selected' => 'Disabled multiple departments.',
    ],

    'status'              => [
        'created'                   => 'Department successfully created',
        'updated'                   => 'Department successfully updated',
        'deleted'                   => 'Department successfully deleted',
        'global-enabled'            => 'Selected departments enabled.',
        'global-disabled'           => 'Selected departments disabled.',
        'enabled'                   => 'Department enabled.',
        'disabled'                  => 'Department disabled.',
        'no-departments-selected'          => 'No departments selected.',
    ],

    'error'               => [
        'cant-be-edited'                => 'Department cannot be edited',
        'cant-be-deleted'               => 'Department cannot be deleted',
        'cant-be-disabled'              => 'Department cannot be disabled',
        'login-failed-departments-disabled'    => 'That account has been disabled.',
        'perm_not_found'                => 'Could not find permission #:id.',
        'departments_not_found'                => 'Could not find departments #:id.',
    ],

    'page'              => [
        'index'              => [
            'title'             => 'Admin | Department',
            'description'       => 'List of departments',
            'table-title'       => 'Department list',
        ],
        'show'              => [
            'title'             => 'Admin | Department | Show',
            'description'       => 'Displaying departments: :full_name',
            'section-title'     => 'Department details'
        ],
        'create'            => [
            'title'            => 'Admin | Department | Create',
            'description'      => 'Creating a new departments',
            'section-title'    => 'New departments'
        ],
        'edit'              => [
            'title'            => 'Admin | Department | Edit',
            'description'      => 'Editing departments: :full_name',
            'section-title'    => 'Edit departments'
        ],
    ],

    'columns'           => [
        'id'                        =>  'ID',
        'gravatar'                  =>  'Gravatar',
        'username'                  =>  'Department name',
        'first_name'                =>  'First name',
        'last_name'                 =>  'Last name',
        'name'                      =>  'Name',
        'assigned'                  =>  'Assigned',
        'roles'                     =>  'Roles',
        'roles-not-found'           =>  'Roles not found',
        'email'                     =>  'Email',
        'type'                      =>  'Type',
        'permissions'               =>  'Permissions',
        'permissions-not-found'     =>  'Permissions not found',
        'password'                  =>  'Password',
        'password_confirmation'     =>  'Password confirmation',
        'created'                   =>  'Created',
        'updated'                   =>  'Updated',
        'actions'                   =>  'Actions',
        'effective'                 =>  'Effective',
        'enabled'                   =>  'Enabled',
        'theme'                     =>  'Theme',
        'time_zone'                 =>  'Time zone',
        'locale'                    =>  'Locale',
        'time_format'               =>  'Time format',
    ],

    'button'               => [
        'create'    =>  'Create new departments',
    ],

    'options'               => [
        '12_hours'    =>  '12 hours',
        '24_hours'    =>  '24 hours',
    ],

    'placeholder'           => [
        'select-theme'         => 'Select a theme',
        'select-time_zone'     => 'Select a time-zone',
        'select-locale'        => 'Select a locale',
    ],



];

