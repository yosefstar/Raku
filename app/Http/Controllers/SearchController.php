<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Item;
use RakutenRws_Client;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $client = new RakutenRws_Client();
        $client->setApplicationId('1070684823768079421');

        $keyword = $request->input('keyword'); // フォームから入力されたキーワードを取得

        $response = $client->execute('IchibaItemSearch', [
            'keyword' => $keyword, // 取得したキーワードを検索に利用
            //  'itemCode' => 'muen-genen:10000176'
        ]);
        $user_id = auth()->user()->id;
        $items = Item::all();
        $myItemLists = Item::where('want_status', 1)->get();
        $itemLists = [];
        foreach ($myItemLists as $myItemList) {
            array_push($itemLists, $myItemList["itemCode"]);
        }

        if ($response->isOk()) {
            $count = $response['count'];
            $items = $response['Items'];

            return view('search', compact('count', 'items', 'myItemLists', 'itemLists'));
        } else {
            $errorMessage = 'Error: ' . $response->getMessage();
            return view('search');
        }
    }


    public function saveItemCode(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('home')->with('error', 'ログインしてください');
        }

        $user_id = auth()->user()->id;
        $imageUrl = $request->input('imageUrl');
        $itemName = $request->input('itemName');
        $itemPrice = $request->input('itemPrice');
        $itemUrl = $request->input('itemUrl');
        $itemCode = $request->input('itemCode');
        $genreName = $request->input('genreName');


        // 保存処理
        $item = Item::create([
            'user_id' => $user_id,
            'imageUrl' => $imageUrl,
            'itemName' => $itemName,
            'itemPrice' => $itemPrice,
            'itemUrl' => $itemUrl,
            'itemCode' => $itemCode,
            'genreName' => $genreName,
            'want_status' => true,
        ]);



        // 保存成功時の処理
        return redirect()->back()->with('success', 'アイテムを追加しました');
    }
}
