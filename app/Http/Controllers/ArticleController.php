<?php

namespace App\Http\Controllers;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(){
		return view('article', [
			"title" => "Artikel Wisata Bromo",
			"articles" => Article::all()
		]);
	}

	public function detail(Article $article){
		return view('article-detail', [
			"article" => $article
		]);
	}
}
