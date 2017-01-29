<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;


class highscoreController extends Controller
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
        
    }

    public function viewHighscore($questId)
    {
    	$data = [];
    	$client = new Client();
        $highscoreResponse = $client->get('http://www.intro.dvc-icta.nl/SpeurtochtApi/web/highscores/' . $questId);
        $questResponse = $client->get('http://www.intro.dvc-icta.nl/SpeurtochtApi/web/speurtocht/' . $questId);
        if ($highscoreResponse->getStatusCode() == 200 && $questResponse->getStatusCode() == 200) {
	        $highscores = json_decode ($highscoreResponse->getBody());
	        $quest = json_decode ($questResponse->getBody());
	        $data['highscores'] = $highscores;
	        $data['quest'] = $quest;
	        return view('highscores/highscore', ['data' => $data]);
	    }
	    else
	    {
	    	echo "Something went wrong";
	    }
    }
}
