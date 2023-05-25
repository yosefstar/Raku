<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Want extends Model
{
    protected $table = 'want_list';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'imageUrl',
        'itemName',
        'itemPrice',
        'itemUrl',
        'itemCode' // 'itemCode' を追加
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'itemCode', 'itemCode'); // 'item_code' を 'itemCode' に修正
    }
}


