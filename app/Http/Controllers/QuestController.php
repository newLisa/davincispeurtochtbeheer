<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Routing\Redirector;

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
    	return view('quest/add');
    }

    public function edit($id)
    {
        $client = new Client();
        
      $res = $client->get('http://www.intro.dvc-icta.nl/SpeurtochtApi/web/speurtocht/' . $id, ['http_errors' => false]);
      
        $status = $res->getStatusCode();
        if ($status == 200)
         {

            $quest = json_decode ($res->getBody());
            return view('quest/edit', ['quest' => $quest]);
        }
        else
        {
            return view('quest/404');

        }       
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

        return redirect()->action('HomeController@index');
    }

    public function putAction($id)
    {
        $client = new Client(['base_uri' => 'http://www.intro.dvc-icta.nl/SpeurtochtApi/web/']);
        $data = $_POST;
        var_dump($data);
        
        $quest['naam'] = $data["name"];
        $quest['opleiding'] = $data['course'];
        $quest['informatie'] = $data['info'];

        $r = $client->request('POST', 'speurtocht/put/' . $id, [
            'body' => json_encode($quest)
        ]);

        return redirect()->action('HomeController@index');
    }

    public function deleteAction($id)
    {
        $client = new Client(['base_uri' => 'http://www.intro.dvc-icta.nl/SpeurtochtApi/web/']);
        $response = $client->request('POST', 'speurtocht/delete/' . $id, []);
        return back();
    }

    public function restoreAction($id)
    {
        $client = new Client(['base_uri' => 'http://www.intro.dvc-icta.nl/SpeurtochtApi/web/']);
        $response = $client->request('POST', 'speurtocht/restore/' . $id, []);
        return back();
    }
}
