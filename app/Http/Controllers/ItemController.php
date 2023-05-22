<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Item;
use RakutenRws_Client;

class ItemController extends Controller
{
    public function search($itemCode)
    {
        $client = new RakutenRws_Client();
        $client->setApplicationId('1006140351693850398');

        // item_listテーブルからitemCodeで商品を検索
        $item = Item::find($itemCode);

        $response = $client->execute('IchibaItemSearch', [
            'itemCode' => $item
        ]);


        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        // 楽天APIで商品を検索
        $response = Http::get($apiUrl, [
            'applicationId' => $apiKey,
            'keyword' => $item->itemCode,
        ]);

        $items = $response->json()['Items'];

        return view('search', compact('items'));
    }
}

