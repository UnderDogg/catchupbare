<?php
namespace Modules\Email\Services;
interface MailRuleServiceContract
{

    public function getAllMailRules();

    public function listAllMailRules();

    public function create($requestData);

    public function destroy($id);
}
