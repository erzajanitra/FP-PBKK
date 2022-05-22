<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;
use App\Http\Models\User;
use DB;
class HomeController extends Controller
{
    //
    public function private()
    {
        // 1. allows
        if (Gate::allows('go-to-private')) {
            return view('private');
        }
        return 'You are not admin!';

        // 2. denies, hasilnya akan sama dengan allows
        // if (Gate::denies('go-to-private')) {
        //     return 'You are not admin!';
        // }
        // return view('private');

        // 3. check
        // if (Gate::check(['go-to-private', 'update-private'])) {
        //     return view('private');
        // }
        // return 'You are not admin!';

        // 4. any
        // if (Gate::any(['go-to-private', 'update-private'])) {
        //     return view('private');
        // }
        // return 'User cannot go to this page or update the page';

        // 5. none
        // if (Gate::none(['go-to-private', 'update-private'])) {
        //     return 'User cannot go to this page or update the page';
        // }
        // return view('private');

        // 6. authorize
        // Gate::authorize('go-to-private');
        // return view('private');

        // 7. for user - allows
        // $user = DB::table('users')->where('id', '1')->first();
        // if (Gate::forUser($user)->allows('go-to-private')) {
        //     return 'User with ID 1 can go to private page';
        // }

        // 8. for user - denies
        // $user = DB::table('users')->where('id', '2')->first();
        // if (Gate::forUser($user)->denies('go-to-private')) {
        //     return 'User with ID 2 cannot go to private page';
        // }
    }

    public function response()
    {
        $response = Gate::inspect('go-to-response');

        if ($response->allowed()) {
            return view('response', ['msg' => 'custom response']); 
        } else {
            echo $response->message();
        }
    }
}
