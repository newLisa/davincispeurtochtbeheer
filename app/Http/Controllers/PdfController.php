<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use PDF;
use Response;
use QrCode;

class PdfController extends Controller
{
    public function index()
    {
  //   	$snappy = PDF::snappy();
		// //To file
		// //
		// QrCode::size(600);
		// QrCode::generate('sfd');
		
		// $html = QrCode::generate('sfd');
		// $snappy->generateFromHtml($html,public_path('/test/test'.rand(1,9999999999).'.pdf'));
		// //$snappy->generate('http://www.github.com', '/tmp/github.pdf');
		// //Or output:
		// $resp =  new Response(
		//     $snappy->getOutputFromHtml($html),
		//     		    		    200,
		//     		    		    array(
		//     		    		        'Content-Type'          => 'application/pdf',
		//     		    		        'Content-Disposition'   => 'attachment; filename="file.pdf"'
		//     		    		    )
		// );



		//return $snappy->download('invoice.pdf');
    }

    public function DownloadPdf($id)
    {

    	$client = new Client();
        
    	$res = $client->get('http://www.intro.dvc-icta.nl/SpeurtochtApi/web/koppeltochtlocatie/' . $id, ['http_errors' => false]);
      
        $status = $res->getStatusCode();
        if ($status == 200)
        {
            $markers = json_decode ($res->getBody());
        }
		
		$markerIds = [];

		for($i = 0; $i < count($markers); $i++)
		{
			$markerIds[$i] = $markers[$i]->id;
		}

    	 return view('test/qrtest',compact('markerIds'));
    }
}
