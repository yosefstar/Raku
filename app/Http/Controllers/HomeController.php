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
        $items = Item::pluck('itemCode'); // item_listテーブルのitemCodeを取得

        return view('home', compact('items'));
    }

    public function search($itemCode)
    {
        $client = new RakutenRws_Client();
        $client->setApplicationId('1006140351693850398');

        // 楽天APIで商品を検索
        $response = $client->execute('IchibaItemSearch', [
            'itemCode' => $itemCode,
        ]);

        $items = $response->getData()['Items'];

        return view('search', compact('items'));
    }

}
