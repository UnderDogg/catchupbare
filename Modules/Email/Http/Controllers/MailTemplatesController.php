<?php

namespace Modules\Email\Http\Controllers;

// controllers
use Modules\Core\Http\Controllers\PhpMailController;
use Modules\Core\Http\Controllers\SettingsController;
use App\Http\Controllers\Controller;
// requests
use Modules\Core\Requests\TemplateRequest;
use Modules\Core\Requests\TemplateUdate;
// models
use Modules\Email\Models\Mailbox;
use Modules\Email\Models\MailTemplate;
use Modules\Core\Models\Language;
// classes
use Exception;
use Illuminate\Http\Request;
use Input;
use Mail;

/**
 * TemplateController.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class MailTemplatesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return type void
     */
    public function __construct(PhpMailController $PhpMailController)
    {
        $this->PhpMailController = $PhpMailController;
        SettingsController::smtp();
        //$this->middleware('auth');
        //$this->middleware('roles');
    }

    /**
     * Display a listing of the resource.
     *
     * @param type MailTemplate $template
     *
     * @return type Response
     */
    public function index(MailTemplate $template)
    {
        //try {
            $templates = $template->get();

            return view('email::mailtemplates.index', compact('templates'));
        //} catch (Exception $e) {
        //    return view('errors.404');
        //}
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param type Languages $language
     * @param type MailTemplate  $template
     *
     * @return type Response
     */
    public function create(Languages $language, MailTemplate $template)
    {
        try {
            $templates = $template->get();
            $languages = $language->get();

            return view('email::mailtemplates.create', compact('languages', 'templates'));
        } catch (Exception $e) {
            return view('errors.404');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param type MailTemplate        $template
     * @param type TemplateRequest $request
     *
     * @return type Response
     */
    public function store(MailTemplate $template, TemplateRequest $request)
    {
        try {
            /* Check whether function success or not */
            if ($template->fill($request->input())->save() == true) {
                /* redirect to Index page with Success Message */
                return redirect('template')->with('success', 'Teams  Created Successfully');
            } else {
                /* redirect to Index page with Fails Message */
                return redirect('template')->with('fails', 'Teams  can not Create');
            }
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('template')->with('fails', 'Teams  can not Create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param type           $id
     * @param type MailTemplate  $template
     * @param type Languages $language
     *
     * @return type Response
     */
    public function listdirectories()
    {
        $path = \Config::get('view.paths')[0].'/emails/';
        $directories = scandir($path);
        $directory = str_replace('/', '-', $path);

        return view('core::emails.template.listdirectories', compact('directories', 'directory'));
    }

    public function listtemplates($template, $path)
    {
        $paths = str_replace('-', '/', $path);
        $directory2 = $paths.$template;

        $templates = scandir($directory2);
        $directory = str_replace('/', '-', $directory2.'/');

        return view('core::emails.template.listtemplates', compact('templates', 'directory'));
    }

    public function readtemplate($template, $path)
    {
        $directory = str_replace('-', '/', $path);
        $handle = fopen($directory.$template, 'r');
        $contents = fread($handle, filesize($directory.$template));
        fclose($handle);

        return view('core::emails.template.readtemplates', compact('contents', 'template', 'path'));
    }

    public function createtemplate()
    {
        $directory = '../resources/views/emails/';
        $fname = Input::get('folder_name');
        $filename = $directory.$fname;

// images folder creation using php
//   $mydir = dirname( __FILE__ )."/html/images";
//   if(!is_dir($mydir)){
//   mkdir("html/images");
//   }
        // Move all images files

        if (!file_exists($filename)) {
            mkdir($filename, 0777);
        }
        $files = array_filter(scandir($directory.'default'));

        foreach ($files as $file) {
            if ($file === '.' or $file === '..') {
                continue;
            }
            if (!is_dir($file)) {
                //   $file_to_go = str_replace("code/resources/views/emails/",'code/resources/views/emails/'.$fname,$file);
                $destination = $directory.$fname.'/';

                copy($directory.'default/'.$file, $destination.$file);
            }
        }

        return \Redirect::back()->with('success', 'Successfully copied');
    }

    public function writetemplate($template, $path)
    {
        $directory = str_replace('-', '/', $path);
        $b = Input::get('templatedata');

        file_put_contents($directory.$template, print_r($b, true));

        return \Redirect::back()->with('success', 'Successfully updated');
    }

    public function deletetemplate($template, $path)
    {
        $directory = str_replace('-', '/', $path);
        $dir = $directory.$template;
        $status = \DB::table('settings_email')->first();
        if ($template == 'default' or $template == $status->template) {
            return \Redirect::back()->with('fails', 'You cannot delete a default or active directory!');
        }
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != '.' && $object != '..') {
                    unlink($dir.'/'.$object);
                }
            }
            rmdir($dir);
        } else {
            rmdir($dir);
        }

        return \Redirect::back()->with('success', 'Successfully Deleted');
    }

    public function activateset($setname)
    {
        \DB::table('settings_email')->update(['template' => $setname]);

        return \Redirect::back()->with('success', 'You have Successfully Activated this Set');
    }

    public function edit($id, MailTemplate $template, Languages $language)
    {
        try {
            $templates = $template->whereId($id)->first();
            $languages = $language->get();

            return view('core::emails.template.edit', compact('templates', 'languages'));
        } catch (Exception $e) {
            return view('errors.404');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param type int           $id
     * @param type MailTemplate      $template
     * @param type TemplateUdate $request
     *
     * @return type Response
     */
    public function update($id, MailTemplate $template, TemplateUdate $request)
    {
        try {
            //TODO validation
            $templates = $template->whereId($id)->first();
            /* Check whether function success or not */
            if ($templates->fill($request->input())->save() == true) {
                /* redirect to Index page with Success Message */
                return redirect('template')->with('success', 'Teams  Updated Successfully');
            } else {
                /* redirect to Index page with Fails Message */
                return redirect('template')->with('fails', 'Teams can not Update');
            }
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('template')->with('fails', 'Teams can not Update');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param type int      $id
     * @param type MailTemplate $template
     *
     * @return type Response
     */
    public function destroy($id, MailTemplate $template)
    {
        try {
            $templates = $template->whereId($id)->first();
            /* Check whether function success or not */
            if ($templates->delete() == true) {
                /* redirect to Index page with Success Message */
                return redirect('template')->with('success', 'Teams  Deleted Successfully');
            } else {
                /* redirect to Index page with Fails Message */
                return redirect('template')->with('fails', 'Teams  can not Delete');
            }
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('template')->with('fails', 'Teams  can not Delete');
        }
    }

    /**
     * Form for Email connection checking.
     *
     * @param type Mailboxes $email
     *
     * @return type Response
     */
    public function formDiagno(Mailbox $mailbox)
    {
        //try {
            $emails = $mailbox->get();

            return view('email::mailtemplates.formDiagno', compact('emails'));
        //} catch (Exception $e) {
        //   return view('errors.404');
        //}
    }

    /**
     * function to send  emails.
     *
     * @param type Request $request
     *
     * @return type
     */
    public function postDiagno(Request $request)
    {
        $mailbox = $request->input('to');
        if ($mailbox == null) {
            return redirect('getdiagno')->with('fails', 'Please provide E-mail address !');
        }
        // sending mail via php mailer
        $mail = $this->PhpMailController->sendmail($from = $this->PhpMailController->mailfrom('1', '0'), $to = ['email' => $mailbox], $message = ['subject' => 'Checking the connection', 'scenario' => 'error-report', 'content' => 'Email Received Successfully'], $template_variables = ['system_error' => 'Email Received Successfully']);

        if ($mail == null) {
            return redirect('getdiagno')->with('fails', 'Please check your E-mail settings. Unable to send mails');
        } else {
            return redirect('getdiagno')->with('success', 'Please check your mail. An E-mail has been sent to your E-mail address');
        }
    }
}
