<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $table = "tx_products";


    protected $fillable = ['name', 'category_id', 'day', 'night', 'star', 'attributes', 'summary', 'route', 'content', 'active'];
    
    // 多对一
    public function category(){
    	return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
