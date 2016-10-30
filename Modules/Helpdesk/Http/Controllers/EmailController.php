<?php
namespace App\Http\Controllers\Client\helpdesk;

// controllers
use App\Http\Controllers\Controller;
// models
use Modules\Email\Models\Emails;

// classes

/**
 * EmailController.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class EmailController extends Controller
{
    /**
     * post port.
     *
     * @return string
     */
    public static function port()
    {
        $port = Emails::where('id', '=', '1')->first();
        $portvalue = $port->option_value;

        return $portvalue;
    }

    /**
     * post host.
     *
     * @return string
     */
    public static function host()
    {
        $host = Option::where('option_name', '=', 'host')->first();
        $hostvalue = $host->option_value;

        return $hostvalue;
    }

    /**
     * post username.
     *
     * @return string
     */
    public static function username()
    {
        $username = Option::where('option_name', '=', 'username')->first();
        $uservalue = $username->option_value;

        return $uservalue;
    }

    /**
     * post passowrd.
     *
     * @return string
     */
    public static function password()
    {
        $password = Option::where('option_name', '=', 'password')->first();
        $passvalue = $password->option_value;

        return $passvalue;
    }

    /**
     * post encryption.
     *
     * @return string
     */
    public static function encryption()
    {
        $encryption = Option::where('option_name', '=', 'encryption')->first();
        $encryptvalue = $encryption->option_value;

        return $encryptvalue;
    }
}
