<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReviewController extends Controller
{
    public function store(Request $request,Tour $tour){
        $data = $request->validate([
            'user_id'=>['required',Rule::exists('users','id')],
            'tour_id'=>['required',Rule::exists('tours','id')],
            'description'=>['required','string','min:5']
        ]);
        $review = new Review();
        $review->user_id = auth()->id();
        $review->tour_id = $tour->id;
        $review->description = $data['description'];
        $result = $review->save();
        if($result){
            return response()->json(['status' => 'true', 'message' => 'Review Added successfully']);
        }else{
        return response()->json(['status' => 'false', 'message' => 'Creation Failed']);
        }
    }
    public function destroy(Review $review){
        $result = $review->delete();
          if($result){
            return response()->json(['status' => 'true', 'message' => 'Review Deleted successfully']);
        }else{
        return response()->json(['status' => 'false', 'message' => 'Delete Failed']);
        }
    }
}
