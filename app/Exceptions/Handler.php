<?php

namespace App\Exceptions;

use App\Libraries\Utils;
use App\Models\Setting;
use Auth;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Input;
use LERN;
use Request;
use View;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        if ($this->shouldReport($e)) {

            //Check to see if LERN is installed otherwise you will not get an exception.
            if (app()->bound("lern")) {

                $lernRecordEnabled = (new Setting())->get('lern.enable_record');
                $lernNotifyEnabled = (new Setting())->get('lern.enable_notify');

                if ($lernRecordEnabled) {
                    app()->make("lern")->record($e); //Record the Exception to the database
                }

                if ($lernNotifyEnabled) {
                    $this->setLERNNotificationFormat(); // Set some formatting options
                    app()->make("lern")->notify($e); //Notify the Exception
                }

            }
        }

        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e) {
        if (config('app.debug') && ! $request->ajax()) {
            $whoops = new \Whoops\Run;
            $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);

            return $whoops->handleException($e);
        }

        return parent::render($request, $e);
    }


    protected function convertExceptionToResponse(Exception $e)
    {
        if (config('app.debug')) {
            $whoops = new \Whoops\Run;
            if(request()->wantsJson())
            {
                $whoops->pushHandler(new \Whoops\Handler\JsonResponseHandler());
            }
            else
            {
                $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
            }

            return response()->make(
                $whoops->handleException($e),
                method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500,
                method_exists($e, 'getHeaders') ? $e->getHeaders() : []
            );
        }

        return parent::convertExceptionToResponse($e);
    }


    private function setLERNNotificationFormat()
    {
        //Change the subject
        LERN::setSubject("[" . (new Setting())->get('lern.notify.channel') . "]: An Exception was thrown! (" . date("D M d, Y G:i", time()) . " UTC)");

        //Change the message body
        LERN::setMessage(function (Exception $exception) {
            $url = Request::url();
            $method = Request::method();
            $staff = Auth::user();
            if ($staff) {
                $staff_id = $staff->id;
                $staff_name = $staff->username;
                $staff_first_name = $staff->first_name;
                $staff_last_name = $staff->last_name;
            } else {
                $staff_id = 'N/A';
                $staff_name = 'unauthenticated';
                $staff_first_name = 'Unauthenticated Staff';
                $staff_last_name = 'N/A';
            }
            $exception_class = get_class($exception);
            $exception_file = $exception->getFile();
            $exception_line = $exception->getLine();
            $exception_message = $exception->getMessage();
            $exception_trace = $exception->getTrace();
            $input = Input::all();
            if (!empty($input)) {
                if (array_has($input, 'password')) {
                    $input['password'] = "hidden-secret";
                    $input['password_confirmation'] = "hidden-secret";
                }
                $input = json_encode($input);
            } else {
                $input = "";
            }

            $exception_trace_formatted = [];
            foreach ($exception->getTrace() as $trace) {
                $formatted_trace = "";

                if (isset($trace['function']) && isset($trace['class'])) {
                    $formatted_trace = sprintf('at %s%s%s(...)', Utils::formatClass($trace['class']), $trace['type'], $trace['function']);
                }
                else if (isset($trace['function'])) {
                    $formatted_trace = sprintf('at %s(...)', $trace['function']);
                }
                if (isset($trace['file']) && isset($trace['line'])) {
                    $formatted_trace .= Utils::formatPath($trace['file'], $trace['line']);
                }
                $exception_trace_formatted[] = $formatted_trace;
            }

            $view = View::make('emails.html.lern_notification', compact('url', 'method', 'staff_id', 'staff_name',
                'staff_first_name', 'staff_last_name', 'exception_class', 'exception_file', 'exception_line',
                'exception_message', 'exception_trace', 'exception_trace_formatted', 'input'));

            $msg = $view->render();

            return $msg;
        });
    }
}
