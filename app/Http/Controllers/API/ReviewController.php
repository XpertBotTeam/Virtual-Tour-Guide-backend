<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(ReviewRequest $reviewRequest , $id){
        $data = $reviewRequest->all();
        $review = new Review($data);
        $review->user_id = $data['user_id'];
        $review->tour_id = $id;
        $result = $review->save();
        if($result){
            return response()->json(['status'=>'true','message'=>'Review Created Successfully'],201);
        }
        return response()->json(['status'=>'false','message'=>'Create Failed'],201);
    }
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        if ($review->user_id != Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $result = $review->delete();
        if ($result) {
            return response()->json(['status' => 'true', 'message' => 'Review Deleted successfully']);
        }
        return response()->json(['status' => 'false', 'message' => 'Delete Failed']);
    }
}
