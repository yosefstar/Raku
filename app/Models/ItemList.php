<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemList extends Model
{
    protected $table = 'item_list';
    protected $fillable = ['itemCode'];
}

