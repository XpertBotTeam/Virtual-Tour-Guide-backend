<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TourUserRequest;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TourUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = auth()->id();
        $tours = Tour::where('user_id', $user_id)->get();
        return response()->json(['status' => 'success', 'tours' => $tours]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(TourUserRequest $request, string $id)
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
