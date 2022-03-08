<?php

namespace App\Repositories\Book;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookRepository
{
    public function getAllBooks(Request $request){
        $paginateValue = $request->query("paginate");
        $allbooks =  DB::table('book')
            ->join('author', 'author.id', '=', 'book.author_id')
            ->join('category', 'category.id', '=', 'book.category_id')
            ->leftJoin('review', 'review.book_id', '=', 'book.id')
            ->leftJoin('discount', 'discount.book_id', '=', 'book.id')
            -> join ('book_avg_rating','book_avg_rating.id','=', 'book.id' )
            ->select('book.id',
                'book.book_title',
                'book.book_price',
                'book.book_cover_photo',
                'category.category_name',
                'author.author_name',

                'book_avg_rating.avg_rating')
            ->selectRaw('(CASE WHEN EXISTS (select discount.book_id from discount where book.id=book_id)
                              THEN (select discount_price from discount where book_id=book.id)
                              ELSE book.book_price END) as final_price')
            ->distinct('book.id')
            ->paginate($paginateValue);

        return $allbooks;
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
    public function getBookByID($id){
        return Book::join('author', 'author.id', '=', 'book.author_id')
            ->leftjoin('category', 'book.category_id', '=', 'category.id')
            ->leftjoin('discount', 'book.id', '=', 'discount.book_id')
            ->leftjoin('book_avg_rating', 'book.id', '=', 'book_avg_rating.id')
            ->leftjoin('count_star', 'book.id', '=', 'count_star.id')
            ->select('book.id',
                'book.book_title',
                'book.book_summary',
                'book.book_price',
                'book.book_cover_photo',
                'discount.discount_price',
                'author.author_name',
                'category.category_name',
                'book_avg_rating.avg_rating',
                'count_star.five_star',
                'count_star.four_star',
                'count_star.three_star',
                'count_star.two_star',
                'count_star.one_star'
            )
            ->where('book.id', '=', $id)
            ->get();
    }
//    public function getListReviewByBookID(Request $request){
//        return Book::
//    }
}
