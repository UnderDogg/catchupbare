<?php

namespace Modules\Knowledgebase\Http\Controllers;

// Controllers
use App\Http\Controllers\Agent\helpdesk\TicketController;
use App\Http\Controllers\Controller;
// Request
use App\Http\Requests\kb\ProfilePassword;
use App\Http\Requests\kb\ProfileRequest;
use App\Http\Requests\kb\SettingsRequests;
use Modules\Core\Models\Utility\Date_format;
// Model
use Modules\Core\Models\Utility\Timezones;
use Modules\Knowledgebase\Models\Comment;
use Modules\Knowledgebase\Models\Settings;
use Auth;
// Classes
use Config;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Image;
use Input;

/**
 * SettingsController
 * This controller is used to perform settings in the setting page of knowledgebase.
 *
 * @author     	Ladybird <info@ladybirdweb.com>
 */
class SettingsController extends Controller
{
    /**
     * Create a new controller instance.
     * constructor to check
     * 1. authentication
     * 2. user roles
     * 3. roles must be agent.
     *
     * @return void
     */
    public function __construct()
    {
        // checking authentication
        //$this->middleware('auth');
        // checking roles
        //$this->middleware('roles');
        $this->language();
    }

    /**
     * to get the settings page.
     *
     * @return response
     */
    public function settings(Settings $settings, Timezones $time, Date_format $date)
    {
        /* get the setting where the id == 1 */
        $settings = $settings->whereId('1')->first();
        $time = $time->get();
        //$date = $date->get();
        return view('knowledgebase::staff.kb.settings.settings', compact('date', 'settings', 'time'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function postSettings($id, Settings $settings, SettingsRequests $request)
    {
        try {
            /* fetch the values of company request  */
            $settings = $settings->whereId('1')->first();
            if (Input::file('logo')) {
                $name = Input::file('logo')->getClientOriginalName();
                $destinationPath = 'lb-faveo/dist/image';
                $fileName = rand(0000, 9999).'.'.$name;
                //echo $fileName;
                Input::file('logo')->move($destinationPath, $fileName);
                $settings->logo = $fileName;
                //$thDestinationPath = 'dist/th';
                Image::make($destinationPath.'/'.$fileName, [
                    'width'     => 300,
                    'height'    => 300,
                    'grayscale' => false,
                ])->save('lb-faveo/dist/image/'.$fileName);
            }
            if (Input::file('background')) {
                $name = Input::file('background')->getClientOriginalName();
                $destinationPath = 'lb-faveo/dist/image';
                $fileName = rand(0000, 9999).'.'.$name;
                echo $fileName;
                Input::file('background')->move($destinationPath, $fileName);
                $settings->background = $fileName;
                //$thDestinationPath = 'dist/th';
                Image::make($destinationPath.'/'.$fileName, [
                    'width'     => 300,
                    'height'    => 300,
                    'grayscale' => false,
                ])->save('lb-faveo/dist/image/'.$fileName);
            }
            /* Check whether function success or not */
            if ($settings->fill($request->except('logo', 'background'))->save() == true) {
                /* redirect to Index page with Success Message */
                return redirect('settings')->with('success', 'Settings Updated Successfully');
            } else {
                /* redirect to Index page with Fails Message */
                return redirect('settings')->with('fails', 'Settings can not Updated');
            }
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('settings')->with('fails', 'Settings can not Updated');
        }
    }

    /**
     * To Moderate the commenting.
     *
     * @param type Comment $comment
     *
     * @return Response
     */
    public function comment(Comment $comment)
    {
        return view('knowledgebase::staff.kb.settings.comment');
    }

    /**
     * getdata.
     *
     * @return type
     */
    public function getData()
    {
        return \Datatable::collection(Comment::All())
                        ->searchColumns('name', 'email', 'comment', 'created')
                        ->orderColumns('name')
                        ->addColumn('name', function ($model) {
                            return $model->name;
                        })
                        ->addColumn('email', function ($model) {
                            return $model->email;
                        })
                        ->addColumn('website', function ($model) {
                            return $model->website;
                        })
                        ->addColumn('comment', function ($model) {
                            return $model->comment;
                        })
                        ->addColumn('status', function ($model) {
                            $status = $model->status;
                            if ($status == 1) {
                                return '<p style="color:blue"">'.\Lang::get('knowledgebase::lang.published');
                            } else {
                                return '<p style="color:red"">'.\Lang::get('knowledgebase::lang.not_published');
                            }
                        })
                        ->addColumn('Created', function ($model) {
                            return TicketController::usertimezone(date($model->created_at));
                        })
                        ->addColumn('Actions', function ($model) {
                            return '<a href=comment/delete/'.$model->id.' class="btn btn-danger btn-xs">'.\Lang::get('knowledgebase::lang.delete').'</a>&nbsp;<a href=published/'.$model->id.' class="btn btn-warning btn-xs">'.\Lang::get('knowledgebase::lang.publish').'</a>';
                        })
                        ->make();
    }

    /**
     * Admin can publish the comment.
     *
     * @param type         $id
     * @param type Comment $comment
     *
     * @return bool
     */
    public function publish($id, Comment $comment)
    {
        $comment = $comment->whereId($id)->first();
        $comment->status = 1;
        if ($comment->save()) {
            return redirect('comment')->with('success', $comment->name.'-'.'Comment Published');
        } else {
            return redirect('comment')->with('fails', 'Can not Process');
        }
    }

    /**
     * delete the comment.
     *
     * @param type         $id
     * @param type Comment $comment
     *
     * @return type
     */
    public function delete($id, Comment $comment)
    {
        $comment = $comment->whereId($id)->first();
        if ($comment->delete()) {
            return redirect('comment')->with('success', $comment->name."'s!".'Comment Deleted');
        } else {
            return redirect('comment')->with('fails', 'Can not Process');
        }
    }

    /**
     * get profile page.
     *
     * @return type view
     */
    public function getProfile()
    {
        $time = Timezone::all();
        $user = Auth::guard('staff')->user();

        return view('knowledgebase::staff.kb.settings.profile', compact('user', 'time'));
    }

    /**
     * Post profile page.
     *
     * @param type ProfileRequest $request
     *
     * @return type redirect
     */
    public function postProfile(ProfileRequest $request)
    {
        $user = Auth::guard('staff')->user();
        $user->gender = $request->input('gender');
        $user->save();
        if (is_null($user->profile_pic)) {
            if ($request->input('gender') == 1) {
                $name = 'avatar5.png';
                $destinationPath = 'lb-faveo/dist/img';
                $user->profile_pic = $name;
            } elseif ($request->input('gender') == 0) {
                $name = 'avatar2.png';
                $destinationPath = 'lb-faveo/dist/img';
                $user->profile_pic = $name;
            }
        }
        if (Input::file('profile_pic')) {
            //$extension = Input::file('profile_pic')->getClientOriginalExtension();
            $name = Input::file('profile_pic')->getClientOriginalName();
            $destinationPath = 'lb-faveo/dist/img';
            $fileName = rand(0000, 9999).'.'.$name;
            //echo $fileName;
            Input::file('profile_pic')->move($destinationPath, $fileName);
            $user->profile_pic = $fileName;
        } else {
            $user->fill($request->except('profile_pic', 'gender'))->save();

            return redirect()->back()->with('success1', 'Profile Updated sucessfully');
        }
        if ($user->fill($request->except('profile_pic'))->save()) {
            return redirect('profile')->with('success1', 'Profile Updated sucessfully');
        } else {
            return redirect('profile')->with('fails1', 'Profile Not Updated sucessfully');
        }
    }

    /**
     * post profile password.
     *
     * @param type                 $id
     * @param type ProfilePassword $request
     *
     * @return type redirect
     */
    public function postProfilePassword($id, ProfilePassword $request)
    {
        $user = Auth::guard('staff')->user();
        //echo $user->password;

        if (Hash::check($request->input('old_password'), $user->getAuthPassword())) {
            $user->password = Hash::make($request->input('new_password'));
            $user->save();

            return redirect('profile')->with('success2', 'Password Updated sucessfully');
        } else {
            return redirect('profile')->with('fails2', 'Old password Wrong');
        }
    }

    /**
     * het locale for language.
     *
     * @return type config set
     */
    public static function language()
    {
        // $set = Settings::whereId(1)->first();
        // $lang = $set->language;
        Config::set('app.locale', 'en');
        Config::get('app');
    }
}
