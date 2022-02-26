<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
class Author extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'author';

    public function book(){
        return $this-> hasMany(Book::class);
}
}
