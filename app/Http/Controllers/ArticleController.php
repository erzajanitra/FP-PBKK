<?php

namespace App\Http\Controllers;
use App\Models\Article;
use Illuminate\Support\Facades\App;

use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(){
		return view('article', [
			"title" => "Artikel Wisata Bromo",
			"articles" => Article::all()
		]);
	}
	// public function indexlocale($locale){
    //     // Chosen locale
    //     App::setlocale($locale);
    //     session()->put('locale', $locale);
    //     // get all data from Ticket table
    //     return view('article', [
	// 		"title" => "Artikel Wisata Bromo",
	// 		"articles" => Article::all()
	// 	]);
    //     // $ticket = Ticket::all();
    //     // return view('ticket');
    // }
	public function detail(Article $article){
		return view('article-detail', [
			"article" => $article
		]);
	}
}
