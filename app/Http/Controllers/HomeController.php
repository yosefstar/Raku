<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use RakutenRws_Client;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $client = new RakutenRws_Client();
        $client->setApplicationId('1006140351693850398');
    
        $response = $client->execute('IchibaItemSearch', [
            'keyword' => 'うどん'
        //  'itemCode' => 'muen-genen:10000176'
        ]);
    
        if ($response->isOk()) {
            $count = $response['count'];
            $items = $response['Items'];
    
            return view('search', compact('count', 'items'));
        } else {
            $errorMessage = 'Error: ' . $response->getMessage();
            return view('search');
        }
    }


}
