<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;


class Item extends Model
{
    protected $table = 'item_list';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'imageUrl',
        'itemName',
        'itemPrice',
        'itemUrl',
        'itemCode',
        'want_status'
    ];

    public function wantList()
    {
        return $this->hasMany(Want::class, 'itemCode', 'itemCode');
    }

    public function store(Request $request)
    {
        $userId = $request->input('user_id');
        $itemCode = $request->input('itemCode');

        // 重複チェック
        $existingWant = Want::where('user_id', $userId)->where('itemCode', $itemCode)->first();
        if ($existingWant) {
            // 重複している場合はエラーメッセージを返すなどの処理を行う
            return response()->json(['error' => 'Duplicate entry'], 422);
        }

        // データの追加処理を行う
        $want = new Want();
        $want->user_id = $userId;
        $want->itemCode = $itemCode;
        // 他の属性の設定...
        $want->save();

        return response()->json(['success' => true]);
    }
}
