<?php

namespace Modules\Email\Http\Controllers;

// controllers
use App;
// models
use App\Http\Controllers\Controller;
use Modules\Email\Models\Mailbox;
use Modules\Email\Models\MailboxProtocol;
use Modules\Tickets\Models\HelpTopic;
use Modules\Core\Models\EmailSettings;
use Modules\Tickets\Models\Ticket;
use Modules\Tickets\Models\TicketAttachment;
use Modules\Tickets\Models\TicketSource;
use Modules\Tickets\Models\TicketThread;
use garethp\ews\API\Type;
use garethp\ews\MailAPI;

// classes
/*use \jamesiarmes\PhpEws\EWSType_FindFolderType;
use \jamesiarmes\PhpEws\EWSType_FolderQueryTraversalType;
use \jamesiarmes\PhpEws\EWSType_FolderResponseShapeType;
use \jamesiarmes\PhpEws\EWSType_DefaultShapeNamesType;
use \jamesiarmes\PhpEws\EWSType_IndexedPageViewType;
use \jamesiarmes\PhpEws\EWSType_NonEmptyArrayOfBaseFolderIdsType;
use \jamesiarmes\PhpEws\EWSType_DistinguishedFolderIdType;
use \jamesiarmes\PhpEws\EWSType_DistinguishedFolderIdNameType;*/

// classes
use Crypt;
use File;
use ForceUTF8\Encoding;
use PhpImap\Mailbox as ImapMailbox;

/**
 * MailController.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class EMailController extends Controller
{
    //TicketWorkflowController $TicketWorkflowController
    /**
     * constructor
     * Create a new controller instance.
     *
     * @param type TicketController $TicketController
     */
    public function __construct()
    {
        //$this->middleware('board');
        //$this->TicketWorkflowController = $TicketWorkflowController;
    }


    public function inbox($id = null)
    {
        $mailbox = MailBox::whereId($id)->first();
        return view('email::inbox.inbox', array('mailbox' => $mailbox));
    }

    public function connectexchange($id = null)
    {
        try {
            $mailbox = MailBox::whereId($id)->first();
        } catch (Exception $e) {
            dd($e->getMessage());
        }

        if ($mailbox->fetching_status == 1) {
            $ticket = new Ticket();
            $auto_response = $mailbox->auto_response;
            $priority = $mailbox->priority_id;
            $dept = $mailbox->department_id;
            $helptopic = $mailbox->helptopic_id;

            $hostserver = $mailbox->fetching_host;
            $username = $mailbox->email_address;
            $version = "2016";
            $password = Crypt::decrypt($mailbox->password);

            try {
                $servername = 'https://'.$hostserver.'/EWS/Exchange.asmx';
                $ews = MailAPI::withUsernameAndPassword($servername, $username, $password);
                /*
                 *        if ($code == 401) {
                 *       throw new UnauthorizedException();
                 *   }
                 *   if ($code == 503) {
                 *       throw new ServiceUnavailableException();
                 *  }
                 *   if ($code >= 300) {
                 *       throw new ExchangeException('SOAP client returned status of ' . $code, $code);
                 *   }
                 **/
            } catch (Exception $exception) {
                if ($exception instanceof \garethp\ews\API\Exception\UnauthorizedException) {
                    echo "error 500";
                    dd($exception->getMessage());
                    //return response()->view('errors.custom', [], 500);
                }
                else {
                    dd($exception->getMessage());
                }
            }

/*            try {
                $mail = $api->getMailItems();
            } catch (\garethp\ews\API\Exception\UnauthorizedException  $UnauthorizedException) {
                $message = "We don't recognize this user ID or password";
                return redirect()->back()->withErrors(array('msg' => $message));
            }*/
        }
        return $ews;

    }


    /*
    * $server: The url to the exchange server you wish to connect to, without the protocol. Example: mail.example.com. If you have trouble determining the correct url,
     * you could try using the \jamesiarmes\PhpEws\Autodiscover class.
    * $username: The user to connect to the server with. This is usually the local portion of the users email address. Example: "user" if the email address is "user@example.com".
    * $password: The user's plain-text password.
    * $version (optional): The version of the Exchange sever to connect to. Valid values can be found at \jamesiarmes\PhpEws\Client::VERSION_*. Defaults to Exchange 2007.
     **/
    public function getMail($id = null)
    {
        ob_implicit_flush();
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        ob_end_flush();
        echo "\n\ndata: connecting to server\n\n";
        flush();

        /*        $email = $emails->get();
                foreach ($email as $e_mail) {*/
        try {
            echo "data: Getting Mailbox Information\n\n";
            flush();
            $mailbox = MailBox::whereId($id)->first();
        } catch (Exception $e) {
            // returns if try fails
            //dd($e->getMessage());
            echo "data: Mailbox with ID not found " . $e->getMessage() . "\n\n";
            flush();
            sleep(1);
            echo "data: end\n\n";
        }

        echo "data: Connecting to the MailServer\n\n";
/*        $hostserver = $mailbox->fetching_host;
        $username = $mailbox->email_address;
        $version = "2016";
        $password = Crypt::decrypt($mailbox->password);
*/
        $ews = new connectexchange($id);
        echo "data: Connecting to the EWS\n\n";
        flush();





/*        if ($mailbox->fetching_status != 1) {
            echo "data: Mailbox Fetching status is not active\n\n";
        }
        else {
            $ticket = new Ticket();
            $auto_response = $mailbox->auto_response;
            $priority = $mailbox->priority_id;
            $dept = $mailbox->department_id;
            $helptopic = $mailbox->helptopic_id;

            $hostserver = $mailbox->fetching_host;
            $username = $mailbox->email_address;
            $version = "2016";
            $password = Crypt::decrypt($mailbox->password);

            echo "data: Connecting to the MailServer\n\n";
            sleep(1);
            flush();

            try {
                echo "data: Connecting to Exchange\n\n";
                flush();
                $ews = new Client($hostserver, $username, $password);
                flush();
                echo "data: ConnectED to Exchange\n\n";
                flush();
                sleep(30);
                echo "data: end\n\n";
                //$mailbox = MailBox::whereId($id)->first();
            } catch (Exception $e) {
                // returns if try fails
                //dd($e->getMessage());
                echo "data: ConnectED and failed to " . print_r($e) . " and failed\n\n";
                //echo "data: Mailbox with ID not found ".$e->getMessage()."\n\n";
                flush();
                sleep(1);
                echo "data: end\n\n";
            }

            echo "data: Nex " . $ews . " try\n\n";
            sleep(30);
            flush();


            echo "data: validation complete\n\n";
            flush();
            sleep(1);
            echo "data: end\n\n";


        }*/


        echo "data: validation complete\n\n";
        flush();
        sleep(1);
        echo "data: end\n\n";
    }


    /**
     * Reademails.
     *
     * @return type
     */
    public function readmails(Emails $emails, Email $settings_email, System $system, Ticket $ticket)
    {
        // $path_url = $system->first()->url;
        if ($settings_email->first()->email_fetching == 1) {
            if ($settings_email->first()->all_emails == 1) {
                // $helptopic = $this->TicketController->default_helptopic();
                // $sla = $this->TicketController->default_sla();
                $email = $emails->get();
                foreach ($email as $e_mail) {
                    if ($e_mail->fetching_status == 1) {
                        $auto_response = $e_mail->auto_response;
                        $priority = $e_mail->priority;
                        $dept = $e_mail->department;
                        $helptopic = $e_mail->help_topic;
                        if ($priority == null) {
                            $priority = $ticket->first()->priority;
                        }
                        if ($dept == null) {
                            $dept = $system->first()->department;
                        }
                        if ($helptopic == null) {
                            $helptopic = $ticket->first()->help_topic;
                        }
                        $get_helptopic = Help_topic::where('id', '=', $helptopic)->first();
                        $sla = $get_helptopic->sla_plan;
                        $host = $e_mail->fetching_host;
                        $port = $e_mail->fetching_port;
                        if ($e_mail->mailbox_protocol) {
                            $protocol_value = $e_mail->mailbox_protocol;
                            $get_mailboxprotocol = MailboxProtocol::where('id', '=', $protocol_value)->first();
                            $protocol = $get_mailboxprotocol->value;
                        } elseif ($e_mail->fetching_encryption == '/none') {
                            $fetching_encryption2 = '/novalidate-cert';
                            $protocol = $fetching_encryption2;
                        } else {
                            if ($e_mail->fetching_protocol) {
                                $fetching_protocol = '/' . $e_mail->fetching_protocol;
                            } else {
                                $fetching_protocol = '';
                            }
                            if ($e_mail->fetching_encryption) {
                                $fetching_encryption = $e_mail->fetching_encryption;
                            } else {
                                $fetching_encryption = '';
                            }
                            $protocol = $fetching_protocol . $fetching_encryption;
                        }
                        $imap_config = '{' . $host . ':' . $port . $protocol . '}INBOX';
                        $password = Crypt::decrypt($e_mail->password);
                        try {
                            $mailbox = new ImapMailbox($imap_config, $e_mail->email_address, $password, __DIR__);
                        } catch (\PhpImap\Exception $e) {
                            echo 'Connection error';
                        }
                        $mails = [];
                        try {
                            $mailsIds = $mailbox->searchMailBox('SINCE ' . date('d-M-Y', strtotime('-1 day')));
                        } catch (\PhpImap\Exception $e) {
                            echo 'Connection error';
                        }
                        if (!$mailsIds) {
                            die('Mailbox is empty');
                        }
                        foreach ($mailsIds as $mailId) {
                            try {
                                $overview = $mailbox->get_overview($mailId);
                            } catch (Exception $e) {
                                return \Lang::get('lang.unable_to_fetch_emails');
                            }
                            $var = $overview[0]->seen ? 'read' : 'unread';
                            if ($var == 'unread') {
                                $mail = $mailbox->getMail($mailId);
                                try {
                                    $mail = $mailbox->getMail($mailId);
                                } catch (\PhpImap\Exception $e) {
                                    echo 'Connection error';
                                }
                                if ($settings_email->first()->email_collaborator == 1) {
                                    $collaborator = $mail->cc;
                                } else {
                                    $collaborator = null;
                                }
                                $body = $mail->textHtml;
                                if ($body != null) {
                                    $body = self::trimTableTag($body);
                                }
                                // if mail body has no messages fetch backup mail
                                if ($body == null) {
                                    $body = $mail->textPlain;
                                }
                                if ($body == null) {
                                    $attach = $mail->getAttachments();
                                    if (is_array($attach)) {
                                        if (array_key_exists('html-body', $attach)) {
                                            $path = $attach['html-body']->filePath;
                                        }
                                        if ($path == null) {
                                            if (array_key_exists('text-body', $attach)) {
                                                $path = $attach['text-body']->filePath;
                                            }
                                        }
                                        if ($path) {
                                            $body = file_get_contents($path);
                                        }
                                        if ($body) {
                                            $body = self::trimTableTag($body);
                                        } else {
                                            $body = '';
                                        }
                                    }
                                }
//                                if ($body == null) {
//                                    $body = $mailbox->backup_getmail($mailId);
//                                    $body = str_replace('\r\n', '<br/>', $body);
//                                }
                                $date = $mail->date;
                                $datetime = $overview[0]->date;
                                $date_time = explode(' ', $datetime);
                                $date = $date_time[1] . '-' . $date_time[2] . '-' . $date_time[3] . ' ' . $date_time[4];
                                $date = date('Y-m-d H:i:s', strtotime($date));
                                if (isset($mail->subject)) {
                                    $subject = $mail->subject;
                                } else {
                                    $subject = 'No Subject';
                                }
                                $fromname = $mail->fromName;
                                $fromaddress = $mail->fromAddress;
                                $ticket_source = Ticket_source::where('name', '=', 'email')->first();
                                $source = $ticket_source->id;
                                $phone = '';
                                $phonecode = '';
                                $mobile_number = '';
                                $assign = $get_helptopic->auto_assign;
                                $form_data = null;
                                $team_assign = null;
                                $ticket_status = null;
                                $result = $this->TicketWorkflowController->workflow($fromaddress, $fromname, $subject, $body, $phone, $phonecode, $mobile_number, $helptopic, $sla, $priority, $source, $collaborator, $dept, $assign, $team_assign, $ticket_status, $form_data, $auto_response, $mail->getAttachments());

                                if ($result[1] == true) {
                                    $ticket_table = Tickets::where('ticket_number', '=', $result[0])->first();
                                    $thread_id = Ticket_Thread::where('ticket_id', '=', $ticket_table->id)->max('id');

                                    $thread_id = $thread_id;
                                    foreach ($mail->getAttachments() as $attachment) {
                                        $support = 'support';

                                        $dir_img_paths = __DIR__;
                                        $dir_img_path = explode('/code', $dir_img_paths);

                                        $filepath = explode('..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'public', $attachment->filePath);

                                        if ($filepath[1]) {
                                            $path = public_path() . $filepath[1];

                                            $filesize = filesize($path);
                                            $file_data = file_get_contents($path);
                                            $ext = pathinfo($attachment->filePath, PATHINFO_EXTENSION);
                                            $imageid = $attachment->id;
                                            $string = str_replace('-', '', $attachment->name);
                                            $filename = explode('src', $attachment->filePath);
                                            $filename = str_replace('\\', '', $filename);
                                            $body = str_replace('cid:' . $imageid, $filepath[1], $body);
                                            $pos = strpos($body, $filepath[1]);
                                            if ($pos == false) {
                                                if ($settings_email->first()->attachment == 1) {
                                                    $upload = new Ticket_attachments();
                                                    $upload->file = $file_data;
                                                    $upload->thread_id = $thread_id;
                                                    $upload->name = $filepath[1];
                                                    $upload->type = $ext;
                                                    $upload->size = $filesize;
                                                    $upload->poster = 'ATTACHMENT';
                                                    $upload->save();
                                                }
                                            } else {
                                                $upload = new Ticket_attachments();
                                                $upload->file = $file_data;
                                                $upload->thread_id = $thread_id;
                                                $upload->name = $filepath[1];
                                                $upload->type = $ext;
                                                $upload->size = $filesize;
                                                $upload->poster = 'INLINE';
                                                $upload->save();
                                            }
                                            unlink($path);
                                        }
                                    }
                                    $body = $body;
                                    $thread = Ticket_Thread::where('id', '=', $thread_id)->first();
                                    $thread->body = $this->separate_reply($body);
                                    $thread->save();
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * separate reply.
     *
     * @param type $body
     *
     * @return type string
     */
    public function separate_reply($body)
    {
        $body2 = explode('---Reply above this line---', $body);
        $body3 = $body2[0];

        return $body3;
    }

    /**
     * Decode Imap text.
     *
     * @param type $str
     *
     * @return type string
     */
    public function decode_imap_text($str)
    {
        $result = '';
        $decode_header = imap_mime_header_decode($str);
        foreach ($decode_header as $obj) {
            $result .= htmlspecialchars(rtrim($obj->text, "\t"));
        }

        return $result;
    }

    /**
     * fetch_attachments.
     *
     * @return type
     */
    public function fetch_attachments()
    {
        $uploads = Upload::all();
        foreach ($uploads as $attachment) {
            $image = @imagecreatefromstring($attachment->file);
            ob_start();
            imagejpeg($image, null, 80);
            $data = ob_get_contents();
            ob_end_clean();
            $var = '<a href="" target="_blank"><img src="data:image/jpg;base64,' . base64_encode($data) . '"/></a>';
            echo '<br/><span class="mailbox-attachment-icon has-img">' . $var . '</span>';
        }
    }

    /**
     * function to load data.
     *
     * @param type $id
     *
     * @return type file
     */
    public function get_data($id)
    {
        $attachments = App\Model\helpdesk\Ticket\Ticket_attachments::where('id', '=', $id)->get();
        foreach ($attachments as $attachment) {
            header('Content-type: application/' . $attachment->type . '');
            header('Content-Disposition: inline; filename=' . $attachment->name . '');
            header('Content-Transfer-Encoding: binary');
            echo $attachment->file;
        }
    }

    public static function trimTableTag($html)
    {
        if (strpos('<table>', $html) != false) {
            $first_pos = strpos($html, '<table');
            $fist_string = substr_replace($html, '', 0, $first_pos);
            $last_pos = strrpos($fist_string, '</table>', -1);
            $total = strlen($fist_string);
            $diff = $total - $last_pos;
            $str = substr_replace($fist_string, '', $last_pos, -1);
            $final_str = str_finish($str, '</table>');

            return $final_str;
        }

        return $html;
    }

    public static function trim3D($html)
    {
        $body = str_replace('=3D', '', $html);

        return $body;
    }

    public static function trimInjections($html, $tags = ['<script>', '</script>', '<style>', '</style>', '<?php', '?>'])
    {
        $replace = [];
        foreach ($tags as $key => $tag) {
            $replace[$key] = htmlspecialchars($tag);
        }
        $body = str_replace($tags, $replace, $html);

        return $body;
    }
}
