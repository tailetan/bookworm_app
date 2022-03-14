<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\support\Facades\Validator;
Use \Carbon\Carbon;


class ReviewController extends Controller
{
    public function update(Request $request)
    {
        $messages =[
            'title.required'=>'Please fill in the title field',
            'details.required'=>'Please fill in the detail field',
            'rating.required'=>'Please select the rating star',

        ];
        $validate = Validator::make($request->all(),[
            'review_title' => ['required', 'string','min:8', 'max:255'],
            'review_details' => ['required', 'string', 'max:255'],
            'rating_star' => ['required'],
        ], $messages);

        if($validate->fails()){
            return response()->json(
                [
                    'message' => $validate->errors(),
                ],
                404
            );
        }
        $date = Carbon::now();
        Review::create([
            'book_id'=>$request->id,
            'review_title' => $request->review_title,
            'review_details' => $request-> review_details,
            'review_date' =>$date->toDateString(),
            'rating_star'=> $request->rating_star,
        ]);
        return response()->json(
            [
                'message' => "Review updated",
            ],
            201
        );
    }
}
