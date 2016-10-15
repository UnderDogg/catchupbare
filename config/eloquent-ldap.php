<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Enabled
    |--------------------------------------------------------------------------
    |
    | The LDAP authentication method is disabled by default, to enabled it set
    | the variable 'LDAP_ENABLED' to true in your '.env' file.
    |
    */

    'enabled' => env('LDAP.ENABLED', false),

    /*
    |--------------------------------------------------------------------------
    | Debug
    |--------------------------------------------------------------------------
    |
    | Enables a higher debug level for the underlying LDAP library. Useful when
    | combined with a packet sniffer to debug connectivity issues.
    |
    */

    'debug' => env('LDAP.DEBUG', 'false'),

    /*
    |--------------------------------------------------------------------------
    | Server type
    |--------------------------------------------------------------------------
    |
    | The server type either 'LDAP' for Lightweight Directory Access Protocol
    | servers, or MSAD for Microsoft Active Directory servers.
    |
    */

    'server_type' => env('LDAP.SERVER_TYPE', 'MSAD'),

    /*
    |--------------------------------------------------------------------------
    | Automatically create new accounts on first login
    |--------------------------------------------------------------------------
    |
    | Should staff accounts be automatically created, if they do not already
    | exists, after successful authentication against the configured
    | LDAP/AD server. This behaviour is set to true by default.
    |
    */

    'create_accounts' => env('LDAP.CREATE_ACCOUNTS', true),

    /*
    |--------------------------------------------------------------------------
    | Automatically replicate group membership
    |--------------------------------------------------------------------------
    |
    | Should a staff's LDAP group membership be replicated in local group/roles?
    | If enabled the package will iterate through all LDAP groups that the
    | staff is a member of and assigned membership of the local group with
    | the same name. This behaviour is set to true by default.
    | NOTE: New groups will not be created, membership will only be granted to
    | existing groups with the same name.
    |
    */

    'replicate_group_membership' => env('LDAP.REPLICATE_GROUP_MEMBERSHIP', true),

    /*
    |--------------------------------------------------------------------------
    | Automatically resync group membership on login
    |--------------------------------------------------------------------------
    |
    | Should a staff's LDAP group membership be resynchronized on every login?
    | If enabled the package will resynchronized group membership on
    | every login.
    | NOTE: New groups will not be created, membership will only be granted to
    | existing groups with the same name.
    |
    */

    'resync_on_login' => env('LDAP.RESYNC_ON_LOGIN', true),

    /*
    |--------------------------------------------------------------------------
    | Group model
    |--------------------------------------------------------------------------
    |
    | Name of model that represents a group or role. This is the model that
    | will automatically be granted membership to based on the staff's LDAP
    | membership if the option 'assign_group' is enabled.
    | NOTE: The staff model is picked up from the 'model' variable in the
    | '\config\auth.php' configuration file.
    |
    */

    'group_model' => env('LDAP.GROUP_MODEL', App\Models\Group::class),

    /*
    |--------------------------------------------------------------------------
    | Internal label
    |--------------------------------------------------------------------------
    |
    | Value to use in the auth_type column for each staff to mark them as
    | internal.
    | NOTE: To avoid errors, the package will consider both staff with
    | an aut_type of this value and null or unset to be internal.
    |
    */

    'label_internal' => env('LDAP.LABEL_INTERNAL', 'internal'),

    /*
    |--------------------------------------------------------------------------
    | LDAP label
    |--------------------------------------------------------------------------
    |
    | Value to use in the auth_type column for each staff to mark them as
    | originating from the LDAP server.
    |
    */

    'label_ldap' => env('LDAP.LABEL_LDAP', 'ldap'),

    /*
    |--------------------------------------------------------------------------
    | Account suffix
    |--------------------------------------------------------------------------
    |
    | Enter the right part of the email address, after and including the "@"
    | sign, configured in your domain. For Microsoft Active Directory this
    | can be your domain name, preceded by the "@" sign.
    |
    */

    'account_suffix' => env('LDAP.ACCOUNT_SUFFIX', "@company.com"),

    /*
    |--------------------------------------------------------------------------
    | Base DN
    |--------------------------------------------------------------------------
    |
    | Enter the LDAP/AD "Base DN" to bind to.
    |
    */

    'base_dn' => env('LDAP.BASE_DN', "DC=department,DC=company,DC=com"),

    /*
    |--------------------------------------------------------------------------
    | Server
    |--------------------------------------------------------------------------
    |
    | Enter the fully qualified hostname for your LDAP server or AD domain
    | controller.
    |
    */

    'server' => [ env('LDAP.SERVER', "ldapsrv01.company.com") ],

    /*
    |--------------------------------------------------------------------------
    | Port
    |--------------------------------------------------------------------------
    |
    | Enter the TCP port number to connect to your AD/LDAP server.
    |
    */

    'port' => env('LDAP.PORT', 389),

    /*
    |--------------------------------------------------------------------------
    | Staff name
    |--------------------------------------------------------------------------
    |
    | Enter the name of the staff that will query the AD/LDAP server.
    |
    */

    'staff_name' => env('LDAP.USER_NAME', "ldap_reader"),

    /*
    |--------------------------------------------------------------------------
    | Password
    |--------------------------------------------------------------------------
    |
    | Enter the password of the staff that will query the AD/LDAP server.
    |
    */

    'password' => env('LDAP.PASSWORD', "PaSsWoRd"),

    /*
    |--------------------------------------------------------------------------
    | Return real primary group
    |--------------------------------------------------------------------------
    |
    | Fix Microsoft AD not following standards by not returning the real
    | primary group, may incur extra processing.
    |
    */

    'return_real_primary_group' => env('LDAP.RETURN_REAL_PRIMARY_GROUP', true),

    /*
    |--------------------------------------------------------------------------
    | Enable encryption?
    |--------------------------------------------------------------------------
    |
    | Enables the use of encryption to communicate with LDAP/AD using either
    | SSL or TLS.
    |
    | Supported values: false, "ssl", "tls"
    |
    */

    'secured' => env('LDAP.SECURED', false),

    /*
    |--------------------------------------------------------------------------
    | Secured port
    |--------------------------------------------------------------------------
    |
    | Enter the port number to use when using secured communications.
    |
    */

    'secured_port' => env('LDAP.SECURED_PORT', 636),

    /*
    |--------------------------------------------------------------------------
    | Resolve all group membership?
    |--------------------------------------------------------------------------
    |
    | Resolve group membership recursively. When disabled only groups that a
    | given staff is a direct member of will be returned. May incur extra
    | processing.
    |
    */

    'recursive_groups' => env('LDAP.RECURSIVE_GROUPS', false),

    /*
    |--------------------------------------------------------------------------
    | Single sign-on
    |--------------------------------------------------------------------------
    |
    | Enable single sign-on.
    | NOTE: This feature is currently not supported
    |
    | TODO: Implement SSO!
    |
    */

    'sso' => env('LDAP.SSO', false),

    /*
    |--------------------------------------------------------------------------
    | Staff name field
    |--------------------------------------------------------------------------
    |
    | Enter the name of the field that will contain the staff name.
    |
    */

    'staffname_field' => env('LDAP.USERNAME_FIELD', "samaccountname"),

    /*
    |--------------------------------------------------------------------------
    | Email field
    |--------------------------------------------------------------------------
    |
    | Enter the name of the field that will contain the staff's email address.
    |
    */

    'email_field' => env('LDAP.EMAIL_FIELD', "staffprincipalname"),

    /*
    |--------------------------------------------------------------------------
    | First name field
    |--------------------------------------------------------------------------
    |
    | Enter the name of the field that will contain the staff's first name.
    |
    */

    'first_name_field' => env('LDAP.FIRST_NAME_FIELD', "givenname"),

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Enter the name of the field that will contain the staff's last name.
    |
    */

    'last_name_field' => env('LDAP.LAST_NAME_FIELD', "sn"),

];

