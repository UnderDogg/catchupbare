<?php
namespace Modules\Email\Services;
interface BreakLineServiceContract
{

    public function getAllBreakLines();

    public function listAllBreakLines();

    public function create($requestData);

    public function destroy($id);
}
