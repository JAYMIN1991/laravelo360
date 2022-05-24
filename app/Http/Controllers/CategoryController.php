<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('category');
    }

    public function store(Request $request)
    {
        $reqData = $request->all();
        $rules = [
            'title' => 'required'
        ];

        $validator = Validator::make($reqData,$rules);
        if($validator->fails()){
            //Session::status('Title field is required');
            Redirect::back()->with('status', 'Title field is required');
        }
    
        //Session::success('You have successfully create goods receive.');
        Session::push('category',$reqData['title']);
        $categoryArr = Session::get('category');
        return view('category',compact('categoryArr'));
    }

    public function saveTODB(Request $request){
        if(Session::get('category') != null){
            //dd(Session::get('category'));
            foreach(Session::get('category') as $category){
                if($category != null){
                    $insertCat = Category::create([
                        'title' => $category
                    ]);
                }
            }
        }
        Session::forget('category');
        $categoryArr = Session::get('category');
        return view('category',compact('categoryArr'));
    }
}
