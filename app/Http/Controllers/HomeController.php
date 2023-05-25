<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Want;
use App\Models\Item;
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $items = Item::all();
        return view('home', compact('items'));
    }

    public function wantItem(Request $request)
    {
        $user_id = auth()->user()->id;
        $imageUrl = $request->input('imageUrl');
        $itemName = $request->input('itemName');
        $itemPrice = $request->input('itemPrice');
        $itemUrl = $request->input('itemUrl');
        $itemCode = $request->input('itemCode');

        Want::create([
            'user_id' => $user_id,
            'imageUrl' => $imageUrl,
            'itemName' => $itemName,
            'itemPrice' => $itemPrice,
            'itemUrl' => $itemUrl,
            'itemCode' => $itemCode
        ]);

        return redirect()->back()->with('success', 'アイテムを追加しました');
    }

    public function showRanking()
{
    $ranking = Want::select('itemCode', DB::raw('count(*) as total'))
        ->groupBy('itemCode')
        ->orderByDesc('total')
        ->get();

    return view('ranking', compact('ranking'));
}
}
