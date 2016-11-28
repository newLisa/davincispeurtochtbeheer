<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class QuestController extends Controller
{

	public function __construct()
    {
        
    }

    public function index()
    {
        
    }

    public function add()
    {
    	return view('quest/addQuest');
    }

    public function postAction()
    {
    	$client = new Client(['base_uri' => 'http://www.intro.dvc-icta.nl/SpeurtochtApi/web/']);
    	$data = $_POST;
    	
    	$quest['naam'] = $data["name"];
    	$quest['opleiding'] = $data['course'];
    	$quest['informatie'] = $data['info'];

    	$r = $client->request('POST', 'speurtocht/', [
		    'body' => json_encode($quest)
		]);
    }
}
