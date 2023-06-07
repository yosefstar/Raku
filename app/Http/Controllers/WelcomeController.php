<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Want;
use App\Models\Item;
use App\Models\Have;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
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
        $user_id = auth()->user()->id;
        // $items = Item::with('wantList')->get();
        $items = Item::all();
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

        return view('home', compact('items', 'itemLists', 'wantLists', 'haveLists', 'myItemLists'));
    }



    public function wantItem(Request $request)
    {
        $user_id = auth()->user()->id;
        $itemCode = $request->input('itemCode');
        $imageUrl = $request->input('imageUrl');
        $itemName = $request->input('itemName');
        $itemPrice = $request->input('itemPrice');
        $itemUrl = $request->input('itemUrl');

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
                'want_status' => true, // もしくは 1
            ]);
        }

        return redirect()->back()->with('success', 'アイテムを追加しました');
    }


    public function haveItem(Request $request)
    {
        $user_id = auth()->user()->id;
        $itemCode = $request->input('itemCode');

        // 重複のチェック
        $existingItem = Have::where('user_id', $user_id)->where('itemCode', $itemCode)->first();
        if ($existingItem) {
            // 重複がある場合はhave_statusの値を変更する
            $existingItem->have_status = !$existingItem->have_status;
            $existingItem->save();
        } else {
            $imageUrl = $request->input('imageUrl');
            $itemName = $request->input('itemName');
            $itemPrice = $request->input('itemPrice');
            $itemUrl = $request->input('itemUrl');

            Have::create([
                'user_id' => $user_id,
                'imageUrl' => $imageUrl,
                'itemName' => $itemName,
                'itemPrice' => $itemPrice,
                'itemUrl' => $itemUrl,
                'itemCode' => $itemCode,
                'have_status' => true, // もしくは 1
            ]);
        }

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
}
