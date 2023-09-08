<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TourRequest;
use App\Models\Tour;
use Illuminate\Http\Request;

class TourController extends Controller
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
        $tour = Tour::create($request->all());
        return response()->json(['success'=>'true','Tour Created Successfully',$tour]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tour = Tour::findOrFail($id);
        return response()->json(['sucess'=>'true',$tour]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TourRequest $request, string $id)
    {
        $tour = Tour::findOrFail($id);
        $tour->update($request->all());
        return response()->json(['success'=>'true','message'=>'Tour Updated Successfully'],201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tour = Tour::findOrFail($id);
        $tour->delete();
        return response()->json(['success'=>'true','message'=>'Tour Deleted Successfully'],203);
    }
}
