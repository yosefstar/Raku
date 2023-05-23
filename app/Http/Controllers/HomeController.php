<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use RakutenRws_Client;
use Illuminate\Support\Facades\Cache;

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
        $client->setApplicationId('1070684823768079421');

        $items = Item::get();

        if ($items->isEmpty()) {
            $errorMessage = 'Error: Items not found';
            return view('home', compact('errorMessage'));
        }

        $searchItems = [];

        $requestInterval = 1;

        foreach ($items as $item) {
            // 直前のリクエストから一定時間が経過するまで待機
            Cache::remember('last_request_time', $requestInterval, function () {
                return time();
            });

            // 現在の時刻と直前のリクエスト時刻を比較して、必要な待機時間を計算
            $lastRequestTime = Cache::get('last_request_time');
            $currentTime = time();
            $elapsedTime = $currentTime - $lastRequestTime;
            $remainingTime = $requestInterval - $elapsedTime;
            if ($remainingTime > 0) {
                sleep($remainingTime);
            }

            // APIリクエストの実行
            try {
                $response = $client->execute('IchibaItemSearch', [
                    'itemCode' => $item->itemCode
                ]);
            } catch (\RakutenRws_Exception $e) {
                $errorMessage = 'Error: ' . $e->getMessage();
                return view('home', compact('errorMessage'));
            }

            // レスポンスの処理
            if ($response->isOk()) {
                $searchItems[] = $response['Items'];
            } else {
                $errorMessage = 'Error: ' . $response->getMessage();
                return view('home', compact('errorMessage'));
            }
        }

        return view('home', compact('searchItems'));
    }

    public function saveItem(Request $request)
    {
        $itemCode = $request->input('itemCode');
        
        // データベースへの保存処理を行う
        // 例: Itemモデルを使用してデータベースに新しいレコードを作成する
        ItemList::create(['itemCode' => $itemCode]);
        
        // 保存完了のメッセージやリダイレクトなど、適切なレスポンスを返す
        return redirect()->back()->with('success', 'アイテムコードを保存しました');
    }
}
