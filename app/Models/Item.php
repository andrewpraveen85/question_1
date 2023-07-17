<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table = 'item';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable = ['order_id', 'menu_id'];
    
    public function menu(){
        return $this->belongsTo(Menu::class, 'menu_id')->withDefault();
    }
}
