<?php

namespace App\Http\Controllers;
use App\Models\Pricelist;
use Illuminate\Http\Request;

class PricelistController extends Controller
{
    public function index(){
		return view('pricelist', [
			"pricelists" => Pricelist::all()
		]);
	}
}
