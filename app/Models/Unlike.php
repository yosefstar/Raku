<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unlike extends Model
{
    protected $table = 'unlike_list';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'imageUrl',
        'itemName',
        'itemPrice',
        'itemUrl',
        'itemCode', // 'itemCode' を追加
        'unlike_status'
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
