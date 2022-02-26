<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
class Discount extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'discount';

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
