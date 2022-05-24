<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Response;
use Auth;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::all()->toArray(); 
        return view('article.list',compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $article = new Article([
            'title' => $request->input('title'),
            'content' => $request->input('content')
        ]);
        $article->save();
        return response()->json('The article successfully added');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = Auth::user()->id;
        $articles = new Article([
            'title' => $request->post('txtTitle'),
            'content'=> $request->post('txtContent'),
            'userid'=> $id
        ]);
		$articles->save();
        //return response()->json($articles);
        return view('article.list',compact('articles'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Article::find($id);
        return response()->json($article);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $id = Auth::user()->id;
        $article = Article::find($request['articleId']);
        $article->title = $request['txtTitle'];
        $article->content = $request['txtContent'];
        $article->userid = $id;
        $article->update();
		return Response::json($article);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::where('id',$id)->delete();
        return Response::json($article);
    }
}
