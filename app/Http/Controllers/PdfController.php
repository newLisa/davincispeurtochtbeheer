<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use PDF;
use Response;
use QrCode;

class PdfController extends Controller
{
    public function DownloadQRPdf($questId)
    {
    	//connect to the api to get markers
    	$client = new Client();
    	$res = $client->get('http://www.intro.dvc-icta.nl/SpeurtochtApi/web/koppeltochtlocatie/' . $questId, ['http_errors' => false]);     
        $status = $res->getStatusCode();
        
        if ($status == 200)
        {
        	//get the marker JSON data from the api
            $markers = json_decode ($res->getBody());
        }

        //connect to the api to get quest data
    	$client = new Client();
    	$res = $client->get('http://www.intro.dvc-icta.nl/SpeurtochtApi/web/speurtocht/' . $questId, ['http_errors' => false]);     
        $status = $res->getStatusCode();
        
        if ($status == 200)
        {
        	//get the quest name JSON data from the api
            $questData = json_decode ($res->getBody());
            $questName = $questData->naam;
        }
		
		//empty array to hold the marker ids as they are in the database
		$markerIds = [];
		//empty arroy to hold the marker names from the db
		$markerNames = [];

		//loop through all the markers
		for($i = 0; $i < count($markers); $i++)
		{
			//check to see if it is a qr-marker
			if ($markers[$i]->is_qr) 
			{
				//add the markerId and names to the array
				$markerIds[] = $markers[$i]->id;
				$markerNames[] = $markers[$i]->name;				
			}
		}

		//show the QR view and send the data with it
    	return view('qr/qr-download',compact('markerIds', 'questName', 'markerNames' ));
    }
}