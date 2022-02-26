<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
class Category extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'category';

    function books(){
        return $this->hasMany(Book::class);
    }
}
