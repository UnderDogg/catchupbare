<?php

use App\Models\Menu;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Route;
use Modules\Email\Models\MailboxProtocol;
use Modules\Core\Models\Staff;
use Illuminate\Database\Seeder;

class ProductionSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* Mailbox protocol */
        $mailbox = [
            'IMAP'                 => '/imap',
            'IMAP+SSL'             => '/imap/ssl',
            'IMAP+TLS'             => '/imap/tls',
            'IMAP+SSL/No-validate' => '/imap/ssl/novalidate-cert', ];

        foreach ($mailbox as $name => $value) {
            MailboxProtocol::create(['name' => $name, 'value' => $value]);
        }
    }
}
