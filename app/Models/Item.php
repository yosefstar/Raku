<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    ];
}
