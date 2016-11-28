<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $client = new Client();
        $res = $client->get('http://www.intro.dvc-icta.nl/SpeurtochtApi/web/speurtocht');
/*      echo $res->getStatusCode();
        echo $res->getBody();*/
        $quests = json_decode ($res->getBody());
        return view('home', ['quests' => $quests]);
    }
}
