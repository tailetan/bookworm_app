<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public function items()
    {
        return $this->belongsToMany(Book::class, 'book_id','order_id','product_id')->withPivot('quantity','price');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
