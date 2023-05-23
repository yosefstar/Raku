<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Want extends Model
{
    protected $table = 'want_list';
    protected $primaryKey = null;
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'item_code',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_code', 'itemCode');
    }
}

