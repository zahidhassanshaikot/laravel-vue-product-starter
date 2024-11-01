<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function loadModal($page_name, $param1 = null)
    {
        $otherLinks         = null;
        if ($param1) :
            $otherLinks     = explode('/', $param1);
        endif;
        return view("admin.modals.$page_name", compact('otherLinks'));
    }
    public function changeLanguage($lang){
        session()->put('locale', $lang);
        return redirect()->back();
    }

}
