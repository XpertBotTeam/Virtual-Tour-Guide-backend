<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Tour;
use Illuminate\Http\Request;

class UserTourController extends Controller
{
    public function index(Request $request)
    {
        $per_page = $request->get('per_page');
        $tours = Tour::paginate($per_page);
        return response()->json(['status' => 'true', 'tours' => $tours]);
    }
    public function show(string $id)
    {
        $tour = Tour::findOrFail($id);
        $reviews = Review::where('tour_id', $id);
        return response()->json(['status' => 'true', 'tour' => $tour, 'reviews' => $reviews]);
    }
}
