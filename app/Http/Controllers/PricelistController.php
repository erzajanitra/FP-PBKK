<?php

namespace App\Http\Controllers;
use App\Models\Pricelist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\App;


class PricelistController extends Controller
{
    public function index(){

		$pricelists = Pricelist::all();
		
		foreach($pricelists as $pl){
			$value[] = Cache::get($pl->id, '0');
		}

		return view('pricelist', [
			"pemesan" => $value,
			"pricelists" => $pricelists
		]);
	}
	public function indexlocale($locale){
        // Chosen locale
        App::setlocale($locale);
        session()->put('locale', $locale);
        // get all data from Ticket table

		$pricelists = Pricelist::all();
		
		foreach($pricelists as $pl){
			$value[] = Cache::get($pl->id, '0');
		}

        return view('pricelist', [
			"pemesan" => $value,
			"pricelists" => $pricelists
		]);
	}}