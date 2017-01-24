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
        $baseUrl = 'http://www.intro.dvc-icta.nl/SpeurtochtApi/web/';
        
        //get the basic info of the quest
        $questRequest = $client->get($baseUrl . 'speurtocht/' . $id, ['http_errors' => false]);  
        //get the polygon from the quest
        $polygonLocationsRequest = $client->get($baseUrl . 'polygon/' . $id, ['http_errors' => false]);
        //get the marker locations from the quest
        $markerLocationsRequest = $client->get($baseUrl . 'koppeltochtlocatie/' . $id, ['http_errors' => false]);

        //create array and put al the jsonRequests in there
        $data = [];
        $data[] = $questRequest;
        $data[] = $polygonLocationsRequest;
        $data[] = $markerLocationsRequest;
      
        //Check if we could get the data else throw exeption
        foreach ($data as $request) {
            if ($request->getStatusCode() != 200)
            {
                return view('quest/404');
            }
        }
        
        $quest = json_decode ($questRequest->getBody());
        $polygonLocations = json_decode ($polygonLocationsRequest->getBody());
        $markerLocations = json_decode ($markerLocationsRequest->getBody());       

        foreach ($markerLocations as $markerLocation) {
            $markerLocation->question = json_decode($client->get($baseUrl . 'vraag/' . $markerLocation->question_id, ['http_errors' => false])->getBody());
        }

        $allQuestData = [];
        $allQuestData['quest'] = $quest;
        $allQuestData['polygonLocations'] = $polygonLocations;
        $allQuestData['markerLocations'] = $markerLocations;


        return view('quest/edit', ['quest' => $allQuestData]);

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
