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
        if (!auth()->check()) {
            return redirect()->back()->with('error', 'ログインしてください');
        }
    
        $user_id = auth()->user()->id;
        $imageUrl = $request->input('imageUrl');
        $itemName = $request->input('itemName');
        $itemPrice = $request->input('itemPrice');
        $itemUrl = $request->input('itemUrl');
        $itemCode = $request->input('itemCode');
    

    
        // 保存処理
        Item::create([
            'user_id' => $user_id,
            'imageUrl' => $imageUrl,
            'itemName' => $itemName,
            'itemPrice' => $itemPrice,
            'itemUrl' => $itemUrl,
            'itemCode' => $itemCode
        ]);
    
        // 保存成功時の処理
        return redirect()->back()->with('success', 'アイテムを追加しました');
    }
    
}

