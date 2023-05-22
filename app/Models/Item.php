<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'item_list';
    protected $primaryKey = 'itemCode';
    public $incrementing = false;
    protected $keyType = 'string';
}