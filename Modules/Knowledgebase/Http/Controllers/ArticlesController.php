<?php

namespace Modules\Knowledgebase\Http\Controllers;

// Controllers
use App\Http\Controllers\Agent\helpdesk\TicketController;
use App\Http\Controllers\Controller;
// Requests
use App\Http\Requests\kb\ArticleRequest;
use App\Http\Requests\kb\ArticleUpdate;
// Models
use Modules\Knowledgebase\Models\Article;
use Modules\Knowledgebase\Models\Category;
use Modules\Knowledgebase\Models\Comment;
use Modules\Knowledgebase\Models\Relationship;
use Modules\Knowledgebase\Models\Settings;
// Classes
use Auth;
use Chumper\Datatable\Table;
use Datatable;
use DB;
use Exception;
use Illuminate\Http\Request;
use Redirect;

/**
 * ArticleController
 * This controller is used to CRUD Articles.
 *
 * @author        Ladybird <info@ladybirdweb.com>
 */
class ArticleController extends Controller
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
        SettingsController::language();
    }

    public function test()
    {
        //$table = $this->setDatatable();
        return view('knowledgebase::staff.kb.article.test');
    }

    /**
     * Fetching all the list of articles in a chumper datatable format.
     *
     * @return type void
     */
    public function getData()
    {
        // returns chumper datatable
        return Datatable::collection(Article::All())
            /* searcable column name */
            ->searchColumns('name')
            /* order column name and description */
            ->orderColumns('name', 'description')
            /* add column name */
            ->addColumn('name', function ($model) {
                return $model->name;
            })
            /* add column Created */
            ->addColumn('Created', function ($model) {
                $t = $model->created_at;

                return TicketController::usertimezone($t);
            })
            /* add column action */
            ->addColumn('Actions', function ($model) {
                /* here are all the action buttons and modal popup to delete articles with confirmations */
                return '<span  data-toggle="modal" data-target="#deletearticle' . $model->id . '"><a href="#" ><button class="btn btn-danger btn-xs"></a> ' . \Lang::get('knowledgebase::lang.delete') . ' </button></span>&nbsp;<a href=article/' . $model->id . '/edit class="btn btn-warning btn-xs">' . \Lang::get('knowledgebase::lang.edit') . '</a>&nbsp;<a href=show/' . $model->slug . ' class="btn btn-primary btn-xs">' . \Lang::get('knowledgebase::lang.view') . '</a>
				<div class="modal fade" id="deletearticle' . $model->id . '">
        			<div class="modal-dialog">
            			<div class="modal-content">
                			<div class="modal-header">
                    			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    			<h4 class="modal-title">Are You Sure ?</h4>
                			</div>
                			<div class="modal-body">
                				' . $model->name . '
                			</div>
                			<div class="modal-footer">
                    			<button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="dismis2">Close</button>
                    			<a href="article/delete/' . $model->slug . '"><button class="btn btn-danger">delete</button></a>
                			</div>
            			</div><!-- /.modal-content -->
        			</div><!-- /.modal-dialog -->
    			</div>';
            })
            ->make();
    }

    /**
     * List of Articles.
     *
     * @return type view
     */
    public function index()
    {
        /* show article list */
        try {
            return view('knowledgebase::staff.kb.article.index');
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->errorInfo[2]);
        }
    }

    /**
     * Creating a Article.
     *
     * @param type Category $category
     *
     * @return type view
     */
    public function create(Category $category)
    {
        /* get the attributes of the category */
        $category = $category->lists('id', 'name');
        /* get the create page  */
        try {
            return view('knowledgebase::staff.kb.article.create', compact('category'));
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->errorInfo[2]);
        }
    }

    /**
     * Insert the values to the article.
     *
     * @param type Article        $article
     * @param type ArticleRequest $request
     *
     * @return type redirect
     */
    public function store(Article $article, ArticleRequest $request)
    {
        // requesting the values to store article data
        $publishTime = $request->input('year') . '-' . $request->input('month') . '-' . $request->input('day') . ' ' . $request->input('hour') . ':' . $request->input('minute') . ':00';

        $sl = $request->input('slug');
        $slug = str_slug($sl, '-');
        $article->slug = $slug;
        $article->publish_time = $publishTime;
        $article->fill($request->except('created_at', 'slug'))->save();
        // creating article category relationship
        $requests = $request->input('category_id');
        $id = $article->id;

        foreach ($requests as $req) {
            DB::insert('insert into kb_article_relationship (category_id, article_id) values (?,?)', [$req, $id]);
        }
        /* insert the values to the article table  */
        try {
            $article->fill($request->except('slug'))->save();

            return redirect('article')->with('success', 'Article Inserted Successfully');
        } catch (Exception $e) {
            return redirect('article')->with('fails', 'Article Not Inserted' . '<li>' . $e->errorInfo[2] . '</li>');
        }
    }

    /**
     * Edit an Article by id.
     *
     * @param type Integer      $id
     * @param type Article      $article
     * @param type Relationship $relation
     * @param type Category     $category
     *
     * @return view
     */
    public function edit($slug, Article $article, Relationship $relation, Category $category)
    {
        $aid = $article->where('id', $slug)->first();
        $id = $aid->id;
        /* define the selected fields */
        $assign = $relation->where('article_id', $id)->lists('category_id');
        /* get the attributes of the category */
        $category = $category->lists('id', 'name');
        /* get the selected article and display it at edit page  */
        /* Get the selected article with id */
        $article = $article->whereId($id)->first();
        /* send to the edit page */
        try {
            return view('knowledgebase::staff.kb.article.edit', compact('assign', 'article', 'category'));
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->errorInfo[2]);
        }
    }

    /**
     * Update an Artile by id.
     *
     * @param type Integer        $id
     * @param type Article        $article
     * @param type Relationship   $relation
     * @param type ArticleRequest $request
     *
     * @return Response
     */
    public function update($slug, Article $article, Relationship $relation, ArticleUpdate $request)
    {
        $aid = $article->where('id', $slug)->first();
        $publishTime = $request->input('year') . '-' . $request->input('month') . '-' . $request->input('day') . ' ' . $request->input('hour') . ':' . $request->input('minute') . ':00';

        $id = $aid->id;
        $sl = $request->input('slug');
        $slug = str_slug($sl, '-');
        // dd($slug);

        $article->slug = $slug;
        /* get the attribute of relation table where id==$id */
        $relation = $relation->where('article_id', $id);
        $relation->delete();
        /* get the request of the current articles */
        $article = $article->whereId($id)->first();
        $requests = $request->input('category_id');
        $id = $article->id;
        foreach ($requests as $req) {
            DB::insert('insert into kb_article_relationship (category_id, article_id) values (?,?)', [$req, $id]);
        }
        /* update the value to the table */
        try {
            $article->fill($request->all())->save();
            $article->slug = $slug;
            $article->publish_time = $publishTime;
            $article->save();

            return redirect('article')->with('success', 'Article Updated Successfully');
        } catch (Exception $e) {
            return redirect('article')->with('fails', 'Article Not Updated' . '<li>' . $e->errorInfo[2] . '</li>');
        }
    }

    /**
     * Delete an Agent by id.
     *
     * @param type $id
     * @param type Article $article
     *
     * @return Response
     */
    public function destroy($slug, Article $article, Relationship $relation, Comment $comment)
    {
        /* delete the selected article from the table */
        $article = $article->where('slug', $slug)->first(); //get the selected article via id
        $id = $article->id;
        $comments = $comment->where('article_id', $id)->get();
        if ($comments) {
            foreach ($comments as $comment) {
                $comment->delete();
            }
        }
        // deleting relationship
        $relation = $relation->where('article_id', $id)->first();
        if ($relation) {
            $relation->delete();
        }
        if ($article) {
            if ($article->delete()) {//true:redirect to index page with success message
                return Redirect::back()->with('success', 'Article Deleted Successfully');
            } else { //redirect to index page with fails message
                return Redirect::back()->with('fails', 'Article Not Deleted');
            }
        } else {
            return Redirect::back()->with('fails', 'Article can Not Deleted');
        }
    }

    /**
     * user time zone
     * fetching timezone.
     *
     * @param type $utc
     *
     * @return type
     */
    public static function usertimezone($utc)
    {
        $user = Auth::guard('staff')->user();
        $tz = $user->timezone;
        $set = Settings::whereId('1')->first();
        $format = $set->dateformat;
        //$utc = date('M d Y h:i:s A');
        date_default_timezone_set($tz);
        $offset = date('Z', strtotime($utc));
        $date = date($format, strtotime($utc) + $offset);
        echo $date;
    }
}
