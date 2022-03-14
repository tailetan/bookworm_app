<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\support\Facades\Validator;


class ReviewController extends Controller
{
    public function review(Request $request)
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
        Review::create([
            'review_title' => $request->review_title,
            'review_detail' => $request-> review_details,
            'rating_star'=> $request->rating_star,
        ]);
        return response()->json(
            [
                'message' => "Reviewed successfully",
            ],
            201
        );
    }
}
