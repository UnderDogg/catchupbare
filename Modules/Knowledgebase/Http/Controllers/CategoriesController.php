<?php
namespace Modules\Knowledgebase\Http\Controllers;

// Controllers
use Modules\Tickets\Http\Controllers\TicketsController;
use App\Http\Controllers\Controller;
// Requests
use App\Http\Requests\kb\CategoryRequest;
use App\Http\Requests\kb\CategoryUpdate;
// Model
use Modules\Knowledgebase\Models\Category;
use Modules\Knowledgebase\Models\Relationship;
// Classes
use Datatables;
use Exception;
use Modules\Knowledgebase\Models\KbCategory;
use Redirect;

/**
 * CategoryController
 * This controller is used to CRUD category.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class CategoriesController extends Controller
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
        //SettingsController::language();
    }

    /**
     * Indexing all Category.
     *
     * @param type Category $category
     *
     * @return Response
     */
    public function index()
    {
        /*  get the view of index of the catogories with all attributes
          of category model */
        //try {
        return view('knowledgebase::categories.index');
        //} catch (Exception $e) {
        //  return redirect()->back()->with('fails', $e->errorInfo[2]);
        //}
    }


    public function anyData()
    {
        //$canUpdateStaff = auth()->user()->can('update-user');
        //Auth::guard($guard)->user()->can('update-user');
        $categories = KbCategory::select(['id', 'slug', 'name', 'parent_id', 'created_at', 'updated_at'])->with('parent');

        return Datatables::of($categories)
            ->addColumn('categorynamelink', function ($categories) {
                return '<a href="/kbpanel/cat/' . $categories->id . '" ">' . $categories->name . '</a>';
            })
            ->addColumn('parentnamelink', function ($categories) {
                return '<a href="/kbpanel/cat/' . $categories->parent_id . '" ">' . $categories->parent_id . '</a>';
            })
            ->addColumn('actions', function ($categories) {
                return '
                <form action="' . route('category.destroy', [$categories->id]) . '" method="POST">
                <div class=\'btn-group\'>
                    <input type="hidden" name="_method" value="DELETE">
                    <a href="' . route('category.edit', [$categories->id]) . '" class=\'btn btn-success btn-xs\'>Edit</a>
                    <input type="submit" name="submit" value="Delete" class="btn btn-danger btn-xs" onClick="return confirm(\'Are you sure?\')"">
                </div>
                </form>';
            })
            ->make(true);
    }


    /**
     * fetching category list in chumper datatables.
     *
     * @return type chumper datatable
     */
    public function getData()
    {
        /* fetching datatables */
        $categories = KbCategory::select(['id', 'slug', 'name', 'parent_id', 'created_at', 'updated_at']);
        return Datatables::of($categories)
            ->addColumn('staffnamelink', function ($categories) {
                return 'name';
            })
            /* add column Created */
            ->addColumn('created', function ($categories) {
                $t = $categories->created_at;
                return $t;
            })
            /* add column Actions */
            /* there are action buttons and modal popup to delete a data column */
            ->addColumn('Actions', function ($categories) {
                return '<span  data-toggle="modal" data-target="#deletecategory' . $categories->slug . '"><a href="#" ><button class="btn btn-danger btn-xs"></a>' . \Lang::get('knowledgebase::lang.delete') . '</button></span>&nbsp;<a href=category/' . $categories->id . '/edit class="btn btn-warning btn-xs">' . \Lang::get('knowledgebase::lang.edit') . '</a>&nbsp;<a href=article-list class="btn btn-primary btn-xs">' . \Lang::get('knowledgebase::lang.view') . '</a>
				<div class="modal fade" id="deletecategory' . $categories->slug . '">
        			<div class="modal-dialog">
            			<div class="modal-content">
                			<div class="modal-header">
                    			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    			<h4 class="modal-title">Are You Sure ?</h4>
                			</div>
                			<div class="modal-body">
                				' . $categories->name . '
                			</div>
                			<div class="modal-footer">
                    			<button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="dismis2">Close</button>
                    			<a href="category/delete/' . $categories->id . '"><button class="btn btn-danger">delete</button></a>
                			</div>
            			</div>
        			</div>
    			</div>';
            })
            ->make();
    }

    /**
     * Create a Category.
     *
     * @param type Category $category
     *
     * @return type view
     */
    public function create(Category $category)
    {
        /* Get the all attributes in the category model */
        $category = $category->get();
        /* get the view page to create new category with all attributes
          of category model */
        //try {
        return view('knowledgebase::categories.create', compact('category'));
        //} catch (Exception $e) {
        //    return redirect()->back()->with('fails', $e->errorInfo[2]);
        //}
    }

    /**
     * To store the selected category.
     *
     * @param type Category        $category
     * @param type CategoryRequest $request
     *
     * @return type Redirect
     */
    public function store(Category $category, CategoryRequest $request)
    {
        /* Get the whole request from the form and insert into table via model */
        $sl = $request->input('slug');
        $slug = str_slug($sl, '-');
        $category->slug = $slug;
        // send success message to index page
        try {
            $category->fill($request->except('slug'))->save();
            return Redirect::back()->with('success', 'Category Inserted Successfully');
        } catch (Exception $e) {
            return Redirect::back()->with('fails', 'Category Not Inserted' . '<li>' . $e->errorInfo[2] . '</li>');
        }
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param type $slug
     * @param type Category $category
     *
     * @return type view
     */
    public function edit($slug, Category $category)
    {
        // fetch the category
        $cid = $category->where('id', $slug)->first();
        $id = $cid->id;
        /* get the atributes of the category model whose id == $id */
        $category = $category->whereId($id)->first();
        /* get the Edit page the selected category via id */
        return view('knowledgebase::categories.edit', compact('category'));
    }

    /**
     * Update the specified Category in storage.
     *
     * @param type $slug
     * @param type Category       $category
     * @param type CategoryUpdate $request
     *
     * @return type redirect
     */
    public function update($slug, Category $category, CategoryUpdate $request)
    {
        /* Edit the selected category via id */
        $category = $category->where('id', $slug)->first();
        $sl = $request->input('slug');
        $slug = str_slug($sl, '-');
        // dd($slug);
        $category->slug = $slug;
        /* update the values at the table via model according with the request */
        //redirct to index page with success message
        try {
            $category->fill($request->all())->save();
            $category->slug = $slug;
            $category->save();
            return redirect('category')->with('success', 'Category Updated Successfully');
        } catch (Exception $e) {
            //redirect to index with fails message
            return redirect('category')->with('fails', 'Category Not Updated' . '<li>' . $e->errorInfo[2] . '</li>');
        }
    }

    /**
     * Remove the specified category from storage.
     *
     * @param type $id
     * @param type Category     $category
     * @param type Relationship $relation
     *
     * @return type Redirect
     */
    public function destroy($id, Category $category, Relationship $relation)
    {
        $relation = $relation->where('category_id', $id)->first();
        if ($relation != null) {
            return Redirect::back()->with('fails', 'Category Not Deleted');
        } else {
            /*  delete the category selected, id == $id */
            $category = $category->whereId($id)->first();
            // redirect to index with success message
            try {
                $category->delete();
                return Redirect::back()->with('success', 'Category Deleted Successfully');
            } catch (Exception $e) {
                return Redirect::back()->with('fails', 'Category Not Deleted' . '<li>' . $e->errorInfo[2] . '</li>');
            }
        }
    }
}
