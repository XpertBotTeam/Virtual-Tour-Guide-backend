<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class TourController extends Controller
{
    public function index(Tour $tour){
        $result = $tour->all();
        return response()->json(['status'=>'success','tours'=>$result]);
    }
public function store(Request $request)
{
    $data = $request->validate([
        'name' => ['required', 'string', 'min:2'],
        'user_id' => ['required', Rule::exists('users', 'id')],
        'category_id' => ['required', Rule::exists('categories', 'id')],
        'address' => ['required', 'string'],
        'city' => ['required', 'string'],
        'country' => ['required', 'string'],
        'phone' => ['required', 'string'],
        'email' => ['required', 'email', Rule::exists('users', 'email')],
        'website' => ['required', 'url'],
        'description' => ['required', 'string'],
        'latitude' => ['required', 'string'],
        'longtitude' => ['required', 'string'],
        'tour_video' => ['required', 'url'],
        'rating' => ['required', 'numeric', 'min:0', 'max:5'],
        'price' => ['required', 'numeric'],
    ]);
    $tour = new Tour();
    $tour->fill($data);
    $result = $tour->save();

    if ($result) {
        return response()->json(['status' => 'true', 'message' => 'Tour created successfully']);
    } else {
        return response()->json(['status' => 'false', 'message' => 'Creation Failed']);
    }
  }
  public function show($id){
    $tour = Tour::find($id);
    $reviews = Review::where('tour_id', $id)->get();
    return response()->json(['status'=>'success','tour'=>$tour,'reviews'=>$reviews]);
  }
  public function update($id,Request $request){
    $tour = Tour::find($id);
       $data = $request->validate([
        'name' => ['required', 'string', 'min:2'],
        'user_id' => ['required', Rule::exists('users', 'id')],
        'category_id' => ['required', Rule::exists('categories', 'id')],
        'address' => ['required', 'string'],
        'city' => ['required', 'string'],
        'country' => ['required', 'string'],
        'phone' => ['required', 'string'],
        'email' => ['required', 'email', Rule::exists('users', 'email')],
        'website' => ['required', 'url'],
        'description' => ['required', 'string'],
        'latitude' => ['required', 'string'],
        'longtitude' => ['required', 'string'],
        'tour_video' => ['required', 'url'],
        'rating' => ['required', 'numeric', 'min:0', 'max:5'],
        'price' => ['required', 'numeric'],
    ]);
    $tour->fill($data);
    $result = $tour->save();
      if ($result) {
        return response()->json(['status' => 'true', 'message' => 'Tour Updated successfully']);
    } else {
        return response()->json(['status' => 'false', 'message' => 'Update Failed']);
    }
}
public function destroy($id){
    $tour = Tour::find($id);
    $result = $tour->delete();
      if ($result) {
        return response()->json(['status' => 'true', 'message' => 'Tour Deleted successfully']);
    } else {
        return response()->json(['status' => 'false', 'message' => 'Delete Failed']);
    }
}
}
