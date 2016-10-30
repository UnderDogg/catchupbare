<?php
namespace Modules\Documents\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Modules\Documents\Models\Document;
use Session;
use Excel;
use Validator;
use Modules\Relations\Models\Relation;
use Modules\Core\Models\Settings;

class DocumentsController extends Controller
{
    public function upload(Request $request, $id)
    {
        $settings = Settings::findOrFail(1);
        $companyname = $settings->company;

        if (!is_dir(public_path() . '/files/' . $companyname)) {
            mkdir(public_path() . '/files/' . $companyname, 0777, true);
        }
        $file = $request->file('file');
        $destinationPath = public_path() . '/files/' . $companyname;
        $filename = str_random(8) . '_' . $file->getRelationOriginalName();
        $fileOrginal = $file->getRelationOriginalName();
        $file->move($destinationPath, $filename);
        $size = $file->getRelationSize();
        $mbsize = $size / 1048576;
        $totaltsize = substr($mbsize, 0, 4);
        if ($totaltsize > 15) {
            Session::flash('flash_message', 'File Size can not be bigger then 15MB');
            return redirect()->back();
        }
        $input = array_replace(
            $request->all(),
            ['path' => "$filename", 'size' => "$totaltsize", 'file_display' => "$fileOrginal", 'fk_relation_id' => $id]
        );
        $document = Document::create($input);
        Session::flash('flash_message', 'File successfully uploaded');
    }

    public function import(Request $request)
    {
        $rules = array(
            'file' => 'required',
            'num_records' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);
        // process the form
        if (!$validator->fails()) {
            return Redirect(route('relations.create'))->withErrors($validator);
        } else {
            try {
                Excel::load('public\imports\contacts.xlsx', function ($reader) {
                    foreach ($reader->toArray() as $row) {
                        if ($row['name'] && $row['company'] && $row['email'] && $row['user'] == "") {
                            Session::flash('flash_message_warning', 'Required fields are empty');
                        }
                    }
                });
                \Session::flash('flash_message', 'Users uploaded successfully.');
                // return redirect(route('admin.relations.relations.index'));
            } catch (\Exception $e) {
                \Session::flash('flash_message_warning', $e->getMessage());
                //return redirect(route('admin.relations.relations.index'));
            }
        }
    }
}
