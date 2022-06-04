<?php

namespace App\Http\Controllers;
use App\Models\Pricelist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PricelistController extends Controller
{
    public function index(){

		$pricelists = Pricelist::all();
		
		foreach($pricelists as $pl){
			if (Cache::has($pl->id)) {
				$value[] = Cache::get($pl->id);
			}
			else $value[] = 0;
		}

		return view('pricelist', [
			"pemesan" => $value,
			"pricelists" => $pricelists
		]);
	}
}
