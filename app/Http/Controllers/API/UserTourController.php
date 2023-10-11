<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Review;
use App\Models\Tour;
use Illuminate\Http\Request;

class UserTourController extends Controller
{
    public function index(Request $request)
    {
        $per_page = $request->get('per_page');
        $tours = Tour::paginate($per_page);
        $catrgories = Category::all();
        return response()->json(['status' => 'true', 'tours' => $tours, 'categories' => $catrgories]);
    }
    public function show(string $id)
    {
        $tour = Tour::findOrFail($id);
        $reviews = Review::where('tour_id', $id);
        return response()->json(['status' => 'true', 'tour' => $tour, 'reviews' => $reviews]);
    }
}
