<?php

namespace App\Repositories\Book;
use App\Models\Book;
interface BookInterface
{
    public function getAllBooks();
    public function getOnSaleBooks();
    public function getRecommendedBooks();

}
