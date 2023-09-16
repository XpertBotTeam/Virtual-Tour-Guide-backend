<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TourRequest;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminTourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $per_page = $request->get('per_page');
        $user_id = auth()->id();
        $tours = Tour::where('user_id', $user_id)->paginate($per_page);
        return response()->json(['status' => 'success', 'tours' => $tours]);
    }
    public function store(TourRequest $tourRequest){
        $tourRequest['user_id'] = auth()->id();
        $link = $tourRequest['tour_video'];
        $patternMobile = '/youtu\.be\/([A-Za-z0-9_-]+)/';
        $patternWeb = '/watch\?v=([A-Za-z0-9_-]+)/';

        if (preg_match($patternMobile, $link, $matches)) {
            $videoId = $matches[1];
        } elseif (preg_match($patternWeb, $link, $matches)) {
            $videoId = $matches[1];
        }
        $tourRequest['tour_video'] = $videoId;
        dd($tourRequest->all());
        $tour = Tour::create($tourRequest->all());
        return response()->json(['success' => 'true', 'Tour Created Successfully', $tour]);
    }
    public function show(string $id){
        $user_id = auth()->id();
        $tour = Tour::where('id',$id)->where('user_id',$user_id)->get();
        return response()->json(['status'=>'true','tour'=>$tour]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(TourRequest $request, string $id)
    {
        $tour = Tour::findOrFail($id);
        if ($tour->user_id != Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $tour->update($request->all());
        return response()->json(['status'=>'true','message'=>'Tour Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tour = Tour::findOrFail($id);
        if ($tour->user_id != Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $tour->delete();
        return response()->json(['status'=>'true','message'=>'Tour Deleted Successfully']);
    }
}
