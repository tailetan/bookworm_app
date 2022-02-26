<?php

namespace App\Repositories\Book;

use App\Models\Book;

class BookRepository
{
    public function getAllBooks(){
        return Book::leftjoin('author', 'author.id', '=', 'book.author_id')
            ->leftjoin('category', 'category.id', '=', 'book.category_id')
            ->leftjoin('review', 'review.book_id', '=', 'book.id')
            ->leftjoin('discount', 'discount.book_id', 'book.id')

            ->select('book.id',
                'book.book_title',
                'book.book_price',
                'book.book_cover_photo',
                'category.category_name',
                'author.author_name',
                'discount.discount_price')
            ->selectRaw('(CASE WHEN EXISTS (select discount.book_id from discount where book.id=book_id)
                              THEN (select discount_price from discount where book_id=book.id)
                              ELSE book.book_price END) as final_price')
            ->distinct()
            ->get();
    }

    public function getOnSaleBooks(){
        return Book::join('discount', 'discount.book_id', '=', 'book.id' )
            -> join('author', 'author.id', '=', 'book.author_id')
            ->selectRaw('book.id,
            book.book_title,
            book.book_price,
            book.book_cover_photo,
            author.author_name,
            discount.discount_price,
            book.book_price - discount.discount_price as sub_price')
            ->orderBy('sub_price', 'desc')
            ->limit(10)
            ->get();
    }

    public function getRecommendedBooks(){
        return  Book::join('author', 'author.id', '=', 'book.author_id')
            ->select('book.id',
                'book.book_title',
                'book.book_price',
                'book.book_cover_photo',
                'author.author_name')

            ->selectRaw('(CASE WHEN EXISTS (select book_id from discount where book.id=book_id)
                              THEN (select discount_price from discount where book_id=book.id)
                              ELSE book.book_price END) as final_price')
            ->join('review', 'review.book_id', '=', 'book.id')
            ->withAvg('review', 'rating_star')
            ->distinct()
            ->orderBy('review_avg_rating_star', 'desc')
            ->orderBy('final_price', 'asc')
            ->limit(8)
            ->get();
    }
    public function getPopularBooks(){
        return Book::join('author', 'author.id', '=', 'book.author_id')
            ->select('book.id',
                'book.book_title',
                'book.book_price',
                'book.book_cover_photo',
                'author.author_name')
            ->selectRaw('(CASE WHEN EXISTS (select book_id from discount where book.id=book_id)
                              THEN (select discount_price from discount where book_id=book.id)
                              ELSE book.book_price END) as final_price')
            ->join('review', 'review.book_id', '=', 'book.id')
            ->withCount('review')
            ->distinct()
            ->orderBy('review_count', 'desc')
            ->orderBy('final_price', 'asc')
            ->limit(8)
            ->get();
    }
}
