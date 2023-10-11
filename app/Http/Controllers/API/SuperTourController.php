<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TourRequest;
use App\Models\Review;
use App\Models\Tour;
use App\Http\Controllers\API\AdminTourController;
use Illuminate\Http\Request;

class SuperTourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $per_page = $request->get('per_page');
        $tours = Tour::paginate($per_page);
        return response()->json(['status' => 'success', 'tours' => $tours]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(TourRequest $request)
    {
        $request['user_id'] = auth()->id();
        $videoId = $this->extractVideoIdFromLink($request['tour_video']);
        $request['tour_video'] = $videoId;
        $tour = Tour::create($request->all());
        return response()->json(['success' => 'true', 'message' => 'Tour Created Successfully', 'tour' => $tour]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tour = Tour::findOrFail($id);
        return response()->json(['sucess' => 'true', 'tour' => $tour]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TourRequest $request, string $id)
    {
        $tour = Tour::findOrFail($id);
        $videoId = $this->extractVideoIdFromLink($request['tour_video']);
        $request['tour_video'] = $videoId;
        $tour->update($request->all());
        return response()->json(['success' => 'true', 'message' => 'Tour Updated Successfully'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tour = Tour::findOrFail($id);
        $tour->delete();
        return response()->json(['success' => 'true', 'message' => 'Tour Deleted Successfully'], 203);
    }
    private function extractVideoIdFromLink($videoLink)
    {
        $patternMobile = '/youtu\.be\/([A-Za-z0-9_-]+)/';
        $patternWeb = '/watch\?v=([A-Za-z0-9_-]+)/';
        $videoId = '';

        if (preg_match($patternMobile, $videoLink, $matches)) {
            $videoId = $matches[1];
        } elseif (preg_match($patternWeb, $videoLink, $matches)) {
            $videoId = $matches[1];
        } else {
            // Extract the video ID from the videoLink with query parameters
            $queryString = parse_url($videoLink, PHP_URL_QUERY);
            parse_str($queryString, $queryArray);

            if (isset($queryArray['v'])) {
                $videoId = $queryArray['v'];
            }
        }

        return $videoId;
    }
}
