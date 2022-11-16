<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_product';

    protected $fillable = [
        'ean13',
        'reference',
    ];

    public function id()
    {
        return $this->id_product;
    }

    public function translations()
    {
        return $this->hasMany(ProductTranslation::class, 'id_product', 'id_product');
    }

}
