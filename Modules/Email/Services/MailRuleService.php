<?php
namespace Modules\Email\Services;

use Modules\Email\Models\MailRule;

class MailRuleService implements MailRuleServiceContract
{

    public function getAllMailRules()
    {
        return MailRule::all();
    }

    public function listAllMailRules()
    {
        return MailRule::pluck('name', 'id');
    }

    public function create($requestData)
    {
        MailRule::create($requestData->all());
    }

    public function destroy($id)
    {
        MailRule::findorFail($id)->delete();
    }
}
