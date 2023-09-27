<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(ReviewRequest $reviewRequest, $id)
    {
        $data = $reviewRequest->all();
        $data['user_id'] = auth()->id();
        $data['tour_id'] = $id;
        $review = new Review();
        $review->user_id = $data['user_id'];
        $review->tour_id = $data['tour_id'];
        $review->description = $data['description'];
        $review->save();
        return response()->json(['status' => 'true', 'message' => 'Review Created Successfully'], 201);
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
