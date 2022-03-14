<?php

namespace App\Http\Controllers;

use App\Repositories\Book\BookRepository;
use Illuminate\Http\Request;

use App\Models\Book;
//use App\Repositories\Book\BookRepository;
class BookController extends Controller
{
    public $bookRepository;
    public function __construct(BookRepository $bookRepository){
        $this->bookRepository = $bookRepository;
    }

    public function getAllBooks(Request $request){

        $allBooks = $this->bookRepository->getAllBooks($request);
         return $allBooks;
    }
    public function getOnSaleBooks(){
        $onSaleBooks = $this->bookRepository->getOnSaleBooks();
        return $onSaleBooks;
    }
    public function getRecommendedBooks(){
        $recommendedBooks = $this->bookRepository->getRecommendedBooks();
        return $recommendedBooks;
    }

    public function getPopularBooks(){
        $popularBooks = $this->bookRepository->getPopularBooks();
        return $popularBooks;
    }

    public function getBookByID($id){
        $book = $this->bookRepository->getBookByID($id);
        return $book;
    }
    public function getAllAuthors(){
        $allAuthors = $this->bookRepository->getAllAuthors();
        return $allAuthors;
    }
    public function getAllCategories(){
        $allCategories = $this->bookRepository->getAllCategories();
        return $allCategories;
    }
    public function getListReviewByID(Request $request){
        $listReview = $this->bookRepository->getListReviewByID($request->id);
        return $listReview;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
