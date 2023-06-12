<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Want;
use App\Models\Item;
use App\Models\Have;
use App\Models\Unlike;
use App\Models\Genre;
use Illuminate\Support\Facades\DB;

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


    public function index(Request $request)
    {
        $user_id = auth()->user()->id;
        // $items = Item::with('wantList')->get();
        $items = Item::whereNotExists(function ($query) use ($user_id) {
            $query->select(DB::raw(1))
                ->from('unlike_list')
                ->whereColumn('unlike_list.itemCode', 'item_list.itemCode')
                ->where('unlike_list.user_id', $user_id);
        })
            ->get();
        $myItemLists = Item::where('user_id', $user_id)->where('want_status', 1)->get();
        $itemLists = [];
        foreach ($myItemLists as $myItemList) {
            array_push($itemLists, $myItemList["itemCode"]);
        }
        $myWantLists = Want::where('user_id', $user_id)->where('want_status', 1)->get();
        $wantLists = [];
        foreach ($myWantLists as $myWantList) {
            array_push($wantLists, $myWantList["itemCode"]);
        }
        $myHaveLists = Have::where('user_id', $user_id)->where('have_status', 1)->get();
        $haveLists = [];
        foreach ($myHaveLists as $myHaveList) {
            array_push($haveLists, $myHaveList["itemCode"]);
        }
        $myUnlikeLists = Unlike::where('user_id', $user_id)->where('unlike_status', 1)->get();
        $unlikeLists = [];
        foreach ($myUnlikeLists as $myUnlikeList) {
            array_push($unlikeLists, $myUnlikeList["itemCode"]);
        }

        $selectedCategory = $request->input('category');

        $categories = [
            'レディースファッション',
            'メンズファッション',
            'インナー・下着・ナイトウェア',
            'バッグ・小物・ブランド雑貨',
            '靴',
            '腕時計',
            'ジュエリー・アクセサリー',
            'キッズ・ベビー・マタニティ',
            'おもちゃ',
            'スポーツ・アウトドア',
            '家電',
            'TV・オーディオ・カメラ',
            'パソコン・周辺機器',
            'スマートフォン・タブレット',
            '光回線・モバイル通信',
            '食品',
            'スイーツ・お菓子',
            '水・ソフトドリンク',
            'ビール・洋酒',
            '日本酒・焼酎',
            'インテリア・寝具・収納',
            '日用品雑貨・文房具・手芸',
            'キッチン用品・食器・調理器具',
            '本・雑誌・コミック',
            'CD・DVD',
            'テレビゲーム',
            'ホビー',
            '楽器・音響機器',
            '車・バイク',
            '車用品・バイク用品',
            '美容・コスメ・香水',
            'ダイエット・健康',
            '医薬品・コンタクト・介護',
            'ペット・ペットグッズ',
            '花・ガーデン・DIY',
            'サービス・リフォーム',
            '住宅・不動産',
            'カタログギフト・チケット',
            '百貨店・総合通販・ギフト',
        ];


        return view('home', compact('items', 'itemLists', 'wantLists', 'haveLists', 'myItemLists', 'unlikeLists', 'categories', 'selectedCategory'));
    }


    public function wantItem(Request $request)
    {
        $user_id = auth()->user()->id;
        $itemCode = $request->input('itemCode');
        $imageUrl = $request->input('imageUrl');
        $itemName = $request->input('itemName');
        $itemPrice = $request->input('itemPrice');
        $itemUrl = $request->input('itemUrl');
        $genreName = $request->input('genreName');

        // 重複のチェック
        $existingItem = Want::where('user_id', $user_id)->where('itemCode', $itemCode)->first();
        if ($existingItem) {
            // 重複がある場合はwant_statusの値を変更する
            $existingItem->want_status = !$existingItem->want_status;
            $existingItem->save();
        } else {


            Want::create([
                'user_id' => $user_id,
                'imageUrl' => $imageUrl,
                'itemName' => $itemName,
                'itemPrice' => $itemPrice,
                'itemUrl' => $itemUrl,
                'itemCode' => $itemCode,
                'genreName' => $genreName,
                'want_status' => true, // もしくは 1
            ]);
        }

        return redirect()->back()->with('success', 'アイテムを追加しました');
    }


    public function haveItem(Request $request)
    {
        $user_id = auth()->user()->id;
        $itemCode = $request->input('itemCode');
        $imageUrl = $request->input('imageUrl');
        $itemName = $request->input('itemName');
        $itemPrice = $request->input('itemPrice');
        $itemUrl = $request->input('itemUrl');
        $genreName = $request->input('genreName');

        // 重複のチェック
        $existingItem = Have::where('user_id', $user_id)->where('itemCode', $itemCode)->first();
        if ($existingItem) {
            // 重複がある場合はhave_statusの値を変更する
            $existingItem->have_status = !$existingItem->have_status;
            $existingItem->save();
        } else {

            Have::create([
                'user_id' => $user_id,
                'imageUrl' => $imageUrl,
                'itemName' => $itemName,
                'itemPrice' => $itemPrice,
                'itemUrl' => $itemUrl,
                'itemCode' => $itemCode,
                'genreName' => $genreName,
                'have_status' => true, // もしくは 1
            ]);
        }

        return redirect()->back()->with('success', 'アイテムを追加しました');
    }

    public function unlikeItem(Request $request)
    {
        $user_id = auth()->user()->id;
        $itemCode = $request->input('itemCode');
        $imageUrl = $request->input('imageUrl');
        $itemName = $request->input('itemName');
        $itemPrice = $request->input('itemPrice');
        $itemUrl = $request->input('itemUrl');
        $genreName = $request->input('genreName');

        Unlike::create([
            'user_id' => $user_id,
            'imageUrl' => $imageUrl,
            'itemName' => $itemName,
            'itemPrice' => $itemPrice,
            'itemUrl' => $itemUrl,
            'itemCode' => $itemCode,
            'genreName' => $genreName,
            'unlike_status' => true, // もしくは 1
        ]);

        return redirect()->back()->with('success', 'アイテムを追加しました');
    }



    public function updateWantStatus()
    {
        return response()->json(['success' => true]);
    }

    public function checkDuplicateAndUpdateStatus(Request $request)
    {
        $user_id = auth()->user()->id;
        $itemCode = $request->input('itemCode');

        // 重複のチェック
        $existingItem = Want::where('user_id', $user_id)->where('itemCode', $itemCode)->first();
        if ($existingItem) {
            // 重複がある場合はwant_statusの値を変更する
            $existingItem->want_status = !$existingItem->want_status;
            $existingItem->save();
        } else {
            $imageUrl = $request->input('imageUrl');
            $itemName = $request->input('itemName');
            $itemPrice = $request->input('itemPrice');
            $itemUrl = $request->input('itemUrl');

            Want::create([
                'user_id' => $user_id,
                'imageUrl' => $imageUrl,
                'itemName' => $itemName,
                'itemPrice' => $itemPrice,
                'itemUrl' => $itemUrl,
                'itemCode' => $itemCode,
                'want_status' => true, // もしくは 1
            ]);
        }

        return redirect()->back()->with('success', 'アイテムを追加しました');
    }




    // public function showRanking()
    // {
    //     $rankings = Want::select('itemCode', DB::raw('COUNT(*) as count'))
    //         ->where('want_status', 1)
    //         ->groupBy('itemCode')
    //         ->orderByDesc('count')
    //         ->get();

    //     // return view('ranking', compact('ranking'));
    //     return view('ranking', ['rankings' => $rankings]);
    // }

    public function showRanking()
    {
        $items = Item::all();
        $wantRankings = Want::select('itemCode', DB::raw('count(*) as total'))
            ->where('want_status', 1)
            ->groupBy('itemCode')
            ->orderByDesc('total')
            ->get();

        $haveRankings = Have::select('itemCode', DB::raw('count(*) as total'))
            ->where('have_status', 1)
            ->groupBy('itemCode')
            ->orderByDesc('total')
            ->get();

        return view('ranking', [
            'wantRankings' => $wantRankings,
            'haveRankings' => $haveRankings
        ]);
    }


    public function removeWantItem(Request $request)
    {
        $user_id = auth()->user()->id;
        $itemCode = $request->input('itemCode');

        // Itemのwant_statusを更新
        $item = want::where('itemCode', $itemCode)->first();
        if ($item) {
            $item->want_status = false; // もしくは 0
            $item->save();
        }

        return redirect()->back()->with('success', 'アイテムのステータスを更新しました');
    }

    public function getItems()
    {
        $user_id = auth()->user()->id;

        $items = Item::leftJoin('want_list', function ($join) use ($user_id) {
            $join->on('items.itemCode', '=', 'want_list.itemCode')
                ->where('want_list.user_id', '=', $user_id);
        })
            ->select('items.*', 'want_list.want_status')
            ->get();

        return view('home', compact('items'));
    }

    public function showItemsByGenre(Request $request)
    {
        // ジャンルの一覧を取得
        $genres = Genre::all();

        // 選択されたジャンルIDを取得
        $selectedGenreId = $request->input('genre');

        // 選択されたジャンルがある場合はそのジャンルに紐づく商品リストを取得
        if ($selectedGenreId) {
            $genre = Genre::findOrFail($selectedGenreId);
            $itemsByGenre = $genre->items;
        } else {
            $itemsByGenre = []; // デフォルトは空の商品リスト
        }

        // ビューに変数を渡して表示
        return view('home', compact('genres', 'selectedGenreId', 'itemsByGenre'));
    }
}
