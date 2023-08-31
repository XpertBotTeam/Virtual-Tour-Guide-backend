<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request){
        $data = $request->validate([
            'name'=>['required','min:7']
        ]);
        $category = new Category();
        $category->fill($data);
        $result = $category->save();
        if($result){
            return response()->json(['status' => 'true', 'message' => 'Categpry Added successfully']);
        }else{
        return response()->json(['status' => 'false', 'message' => 'Creation Failed']);
        }
    }
    public function destroy($id){
        $category = Category::find($id);
        if(isset($category)){
             $result = $category->delete();
            if($result){
                return response()->json(['status' => 'true', 'message' => 'Categpry Deleted successfully']);
            }else{
                return response()->json(['status' => 'false', 'message' => 'Delete Failed']);
            }
        }else{
            return response()->json(['status'=>'false','message'=>'Invalid Id']);
        }
    }
}
