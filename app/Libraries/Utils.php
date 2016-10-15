<?php namespace App\Libraries;

use App\Models\Setting;
use App\Repositories\AuditRepository as Audit;
use App\Staff;
use Auth;
use DateTime;
use DateTimeZone;
use Flash;
use Illuminate\Support\Arr;

class Utils
{


    /**
     * Transform the input string into function 1, 2 or 3 parameters.
     * Used in Blade template to call the str_head, str_tail and
     * str_head_and_tail functions.
     *
     * @param $expression
     * @return array
     */
    public static function getParmsForStrHeadAndTails($expression)
    {
        $parms = self::splitBladeParameters($expression);
        $parmsCnt = count($parms);
        switch ($parmsCnt) {
            case 1:
                $value = $parms[0];
                $limit = 100;
                $end = '...';
                break;
            case 2:
                $value = $parms[0];
                $limit = $parms[1];
                $end = '...';
                break;
            case 3:
                $value = $parms[0];
                $limit = $parms[1];
                $end = $parms[2];
                $end = str_replace(['"', "'"], '', $end);
                break;
        }
        return array($value, $limit, $end);
    }


    /**
     * Iterate through the flattened array of settings and removes
     * all staff settings. A new array is build and returned.
     *
     * Staff settings are found to start with the 'Staff" key followed by a number,
     * both parts are separated by a dot ('.').
     *
     * @param $allSettings
     * @return array
     */
    public static function FilterOutStaffSettings($allSettings)
    {
        $allNonStaffSetting = Arr::where($allSettings, function ($k) {
            if ("Staff." === substr( $k, 0, 5 ) ) {
                $kparts = explode('.', $k);
                $staff = Staff::ofStaffname($kparts[1])->first();
                if ($staff instanceof Staff) {
                    return false;
                }
            }

            return true;
        });

        return $allNonStaffSetting;
    }


    /**
     * Evaluate the input variable and if the string can be converted to either
     * a boolean, float or integer converts it and return that value.
     * Otherwise simply return the inout variable unchanged.
     *
     * @param $value
     * @return bool|float|int|misc
     */
    public static function correctType($value)
    {
        try {
            if (Str::isBoolean($value)) {
                $value = Str::toBoolean($value);
            } elseif (is_float($value)) {
                $value = floatval($value);
            } elseif (is_int($value)) {
                $value = intval($value);
            }
        } catch (Exception $ex) {}

        return $value;
    }



    /**
     * Send flash message to the staff screen and logs an audit log. If an exception is provided
     * the exception message will be included in the audit log entry.
     *
     * @param $auditCategory
     * @param $msg
     * @param $flashLevel
     * @param null $exception
     */
    public static function flashAndAudit($auditCategory, $msg, $flashLevel, $exception = null)
    {
        $auditMsg = $msg;

        // Get current staff or set guest to true for unauthenticated staff.
        if ( Auth::check() ) {
            $staff       = Auth::user();

            if( (isset($exception)) && (strlen($exception->getMessage()) > 0) ) {
                $auditMsg = $msg . " Exception information: " . $exception->getMessage();
            }
            switch ($flashLevel) {
                case FlashLevel::INFO:
                    Flash::info($msg);
                    break;
                case FlashLevel::SUCCESS:
                    Flash::success($msg);
                    break;
                case FlashLevel::WARNING:
                    Flash::warning($msg);
                    break;
                // case FlashLevel::ERROR
                default:
                    Flash::error($msg);
                    break;

            }
            Audit::log( $staff->id, $auditCategory, $auditMsg );
        }
    }

    /**
     * Process the parameter input from a blade directive and splits it
     * into an array of parameters.
     *
     * @param $expression
     * @return array
     */
    public static function splitBladeParameters($expression)
    {
        $expCleaned = str_replace(['(', ')', ' '], '', $expression);
        $parms = explode(',', $expCleaned);

        return $parms;
    }


    /**
     * @param $utcDate
     * @return string
     */
//    public static function convertToLocalDateTime($utcDate)
    public static function staffTimeZone($date)
    {
        $time_zone = Utils::getStaffOrAppOrDefaultSetting('time_zone', 'app.time_zone', 'UTC');
        $time_format = Utils::getStaffOrAppOrDefaultSetting('time_format', 'app.time_format', '24');

        // Get the time zone abbreviation to display from the time zone identifier
        $dateTime = new DateTime();
        $dateTime->setTimeZone(new DateTimeZone($time_zone));
        $tzAbrev = $dateTime->format('T');
        // Convert system time to staff's timezone
        $locDate = $date;
        $locDate->setTimeZone(new DateTimeZone($time_zone));

        if ("12" == $time_format) {
            $finalSTR = $locDate->format('Y-m-d g:i A') . " " . $tzAbrev; // output: 2011-04-26 8:45 PM EST
        } else {
            $finalSTR = $locDate->format('Y-m-d H:i') . " " . $tzAbrev; // output: 2011-04-26 20:45 EST
        }

        return $finalSTR;
    }


    /**
     * @return mixed|null
     */
    public static function getStaffOrAppOrDefaultSetting($staffKey, $appKey = null, $default = null)
    {
        $setting = null;

        if (null == $appKey) {
            $appKey = $staffKey;
        }

        if (\Auth::check()) {
            $staff = \Auth::user();
            $setting = $staff->settings()->get($staffKey);
        }
        if (null == $setting) {
            $setting = (new Setting())->get($appKey, $default);
        }
        return $setting;
    }


    public static function formatClass($class)
    {
        $parts = explode('\\', $class);

        return sprintf('<abbr title="%s">%s</abbr>', $class, array_pop($parts));
    }

    public static function formatPath($path, $line)
    {
        $path = self::escapeHtml($path);
        $file = preg_match('#[^/\\\\]*$#', $path, $file) ? $file[0] : $path;

        $fileLinkFormat = ini_get('xdebug.file_link_format') ?: get_cfg_var('xdebug.file_link_format');

        if ($linkFormat = $fileLinkFormat) {
            $link = strtr(self::escapeHtml($linkFormat), array('%f' => $path, '%l' => (int) $line));

            return sprintf(' in <a href="%s" title="Go to source">%s line %d</a>', $link, $file, $line);
        }

        return sprintf(' in <a title="%s line %3$d" ondblclick="var f=this.innerHTML;this.innerHTML=this.title;this.title=f;">%s line %d</a>', $path, $file, $line);
    }

    /**
     * HTML-encodes a string.
     */
    public static function escapeHtml($str)
    {
        $charset = ini_get('default_charset') ?: 'UTF-8';
        return htmlspecialchars($str, ENT_QUOTES | (PHP_VERSION_ID >= 50400 ? ENT_SUBSTITUTE : 0), $charset);
    }


}
