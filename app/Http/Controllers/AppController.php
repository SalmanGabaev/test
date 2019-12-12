<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AppController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        return \redirect()->route('home', app()->getLocale());
    }

    public function setLocale($locale) {
        App::setLocale($locale);
        //storing the locale in session to get it back in the middleware
        session()->put('locale', $locale);
        return redirect()->back();
    }
}
