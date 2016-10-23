<?php
namespace Modules\Email\Services;

use Modules\Email\Models\BreakLine;

class BreakLineService implements BreakLineServiceContract
{

    public function getAllBreakLines()
    {
        return BreakLine::all();
    }

    public function listAllBreakLines()
    {
        return BreakLine::pluck('name', 'id');
    }

    public function create($requestData)
    {
        BreakLine::create($requestData->all());
    }

    public function destroy($id)
    {
        BreakLine::findorFail($id)->delete();
    }
}
