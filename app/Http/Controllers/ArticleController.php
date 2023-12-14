<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Carbon\Carbon;


class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::all();
        return $articles;
    }
    public function store(Request $request)
    {
        $article = Article::create([
            'title' => $request->title,
            'description' => $request->description,
            'reference' => $request->reference,
        ]);
        $article->save();
        return $article;
    }
    public function update(Request $request, $id)
    {
        $article = Article::find($id);
        $article->update([
            'title' => $request->title,
            'description' => $request->description,
            'reference' => $request->reference,
        ]);
        $article->update();
        return $article;
    }
    public function destroy($id)
    {
        $article = Article::find($id);
        $article->delete();
        return response()->json([
            'Success' => 'Article Deleted Succuffly',
        ]);
    }
    public function GetTodayArticle()
    {
        $today = Carbon::today();
        $articles = Article::whereDate('created_at', $today)->get();
        return $articles;
    }
    public function GetLastWeekArticle()
    {
        $today = Carbon::now();
        $week = $today->subDays(7);
        $articles = Article::whereDate('created_at', '>=', $week)->get();
        return $articles;
    }
    public function GetLastMounthArticle()
    {
        $today = Carbon::now();
        $month = $today->subMonth(1);
        $articles = Article::whereDate('created_at',  $month)->get();
        return $articles;
    }
    public function show(string $id)
    {
        $article = Article::find($id);
        return $article;
    }
}
