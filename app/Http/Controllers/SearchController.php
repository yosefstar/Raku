<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\ItemList;
use RakutenRws_Client;

class SearchController extends Controller
{
    public function index()
    {
        $client = new RakutenRws_Client();
        $client->setApplicationId('1070684823768079421');
    
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

    public function saveItemCode(Request $request)
    {
        $itemCode = $request->input('itemCode');

        ItemList::create(['itemCode' => $itemCode]);

        // 保存成功時の処理

        return redirect()->back()->with('success', 'アイテムコードを保存しました');
    }
}

