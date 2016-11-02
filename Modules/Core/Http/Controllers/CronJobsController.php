<?php

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Email\Models\Mailbox;
use Modules\Email\Models\MailTemplate;
use Modules\Tickets\Models\WorkflowClose;




//use App\Model\helpdesk\Settings\CommonSettings;
//use App\Model\helpdesk\Settings\Company;

use App\Model\helpdesk\Settings\Followup;

use Modules\Email\Models\AutoResponder;
use Modules\Email\Models\EmailSetting;
use Modules\Core\Models\SystemSetting;
use Modules\Tickets\Models\TicketSetting;





class CronJobsController extends Controller
{
    /**
     * get the form for cron job setting page.
     *
     * @param type Email    $mailbox
     * @param type Template $mailtemplate
     * @param type Emails   $mailbox1
     *
     * @return type Response
     */
    public function getScheduler(EmailSetting $emailsetting, MailTemplate $mailtemplate, Mailbox $mailbox, WorkflowClose $workflow)
    {
        // try {
        /* fetch the values of email from Email table */
        $emailsettings = $emailsetting->whereId('1')->first();
        /* Fetch the values from Template table */
        $mailtemplates = $mailtemplate->get();
        /* Fetch the values from Emails table */
        $mailboxes = $mailbox->get();

        $workflow = $workflow->whereId('1')->first();
        $cron_path = base_path('artisan');
        $command = ":- <pre>***** php $cron_path schedule:run > /dev/null 2>&1</pre>";
        $shared = ":- <pre>/usr/bin/php-cli -q  $cron_path schedule:run > /dev/null 2>&1</pre>";
        $warn = '';
        $condition = new \Modules\Email\Models\Condition();
        $job = $condition->checkActiveJob();
        $commands = [
            ''                   => 'Select',
            'everyMinute'        => 'Every Minute',
            'everyFiveMinutes'   => 'Every Five Minute',
            'everyTenMinutes'    => 'Every Ten Minute',
            'everyThirtyMinutes' => 'Every Thirty Minute',
            'hourly'             => 'Every Hour',
            'daily'              => 'Every Day',
            'dailyAt'            => 'Daily at',
            'weekly'             => 'Every Week',
            'monthly'            => 'Monthly',
            'yearly'             => 'Yearly',
        ];
        $followupcommands = [
            ''                   => 'Select',
            'everyMinute'        => 'Every Minute',
            'everyFiveMinutes'   => 'Every Five Minute',
            'everyTenMinutes'    => 'Every Ten Minute',
            'everyThirtyMinutes' => 'Every Thirty Minute',
            'hourly'             => 'Every Hour',
            'daily'              => 'Every Day',
            'weekly'             => 'Every Week',
            'monthly'            => 'Monthly',
            'yearly'             => 'Yearly',
        ];
        if (ini_get('register_argc_argv') == '') {
            //$warn = "Please make 'register_argc_argv' flag as on. Or you can set all your job url in cron";
        }

        return view('core::admin.cron.cron', compact('emailsettings', 'mailtemplates', 'mailboxes', 'workflow', 'warn', 'command', 'commands', 'followupcommands', 'condition', 'shared'));
        // } catch {
        // }
    }

    /**
     * Update the specified schedular in storage for cron job.
     *
     * @param type Email        $mailbox
     * @param type EmailRequest $request
     *
     * @return type Response
     */
    public function postScheduler(Email $mailbox, MailTemplate $mailtemplate, Followup $followup, Emails $mailbox1, TaskRequest $request, WorkflowClose $workflow)
    {
        try {
            $followup = $followup->whereId('1')->first();
            $status = $request->followup_notification_cron;

            if ($status = 'null') {
                $followup->status = $request->followup_notification_cron;
            }
            if ($status = 1) {
                $followup->status = $request->followup_notification_cron;
                $followup->condition = $request->followup_notification_commands;
                $followup->save();
            }
            if ($request->followup_notification_dailyAt) {
                $followup->condition = $request->followup_notification_dailyAt;
                $followup->save();
            }

            /* fetch the values of email request  */
            $mailboxes = $mailbox->whereId('1')->first();
            if ($request->email_fetching) {
                $mailboxes->email_fetching = $request->email_fetching;
            } else {
                $mailboxes->email_fetching = 0;
            }
            if ($request->notification_cron) {
                $mailboxes->notification_cron = $request->notification_cron;
            } else {
                $mailboxes->notification_cron = 0;
            }
            $mailboxes->save();
            //workflow
            $work = $workflow->whereId('1')->first();
            if ($request->condition) {
                $work->condition = 1;
            } else {
                $work->condition = 0;
            }
            $work->save();
            $this->saveConditions();
            /* redirect to Index page with Success Message */
            return redirect('job-scheduler')->with('success', Lang::get('lang.job-scheduler-success'));
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('job-scheduler')->with('fails', Lang::get('lang.job-scheduler-error').'<li>'.$e->getMessage().'</li>');
        }
    }

    public function saveConditions()
    {
        if (\Input::get('fetching-commands') && \Input::get('notification-commands')) {
            $fetching_commands = \Input::get('fetching-commands');
            $fetching_dailyAt = \Input::get('fetching-dailyAt');
            $notification_commands = \Input::get('notification-commands');
            $notification_dailyAt = \Input::get('notification-dailyAt');
            $work_commands = \Input::get('work-commands');
            $workflow_dailyAt = \Input::get('workflow-dailyAt');
            $fetching_command = $this->getCommand($fetching_commands, $fetching_dailyAt);
            $notification_command = $this->getCommand($notification_commands, $notification_dailyAt);
            $work_command = $this->getCommand($work_commands, $workflow_dailyAt);
            $jobs = ['fetching' => $fetching_command, 'notification' => $notification_command, 'work' => $work_command];
            $this->storeCommand($jobs);
        }
    }

    public function getCommand($command, $daily_at)
    {
        if ($command == 'dailyAt') {
            $command = "dailyAt,$daily_at";
        }

        return $command;
    }

    public function storeCommand($array = [])
    {
        $command = new \App\Model\MailJob\Condition();
        $commands = $command->get();
        if ($commands->count() > 0) {
            foreach ($commands as $condition) {
                $condition->delete();
            }
        }
        if (count($array) > 0) {
            foreach ($array as $key => $save) {
                $command->create([
                    'job'   => $key,
                    'value' => $save,
                ]);
            }
        }
    }
}
