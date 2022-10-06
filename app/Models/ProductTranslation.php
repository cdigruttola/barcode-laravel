<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    use HasFactory;

    protected $primaryKey = ['id_product', 'language_code'];
    public $incrementing = false;


    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }
}
