<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $table = 'menu';
    protected $primaryKey = 'id';
    public $incrementing = true;
    
    public function items(){
        return $this->hasmany('Item');
    }
}
