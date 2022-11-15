<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Capacity;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CapacityController extends Controller
{
    public function getAll()
    {
        try {
            $data = Capacity::get();
            return response()->json($data);
        } catch (QueryException $e) {
            return response()->json(["Something Went Wrong!", $e->getMessage(), 500]);
        }
    }
    public function create(Request $request)
    {
        $request->validate([
            'name' => ['string'],
        ]);
        try {
            $capacity = new Capacity();
            $capacity->name = $request->name;
            $capacity->save();
            return response()->json(["Create Successfully!", 200]);
        } catch (QueryException $e) {
            return response()->json(["Something Went Wrong!", $e->getMessage(), 500]);
        }
    }
    public function update(Request $request)
    {
        $request->validate([
            'name' => ['string'],
        ]);

        try {
            $capacity = Capacity::find($request->id);
            $capacity->name = $request->name;
            $capacity->save();
            return response()->json(['Update Successfully!', 200]);
        } catch (QueryException $e) {
            return response()->json(["Something Went Wrong!", $e->getMessage(), 500]);
        }
    }
    public function delete($id)
    {
        try {
            $capacity =  Capacity::find($id);
            if ($capacity) {
                $capacity->delete();
                return response()->json(['Deleted Successfully!', 200]);
            }
        } catch (QueryException $e) {
            return response()->json(["Something Went Wrong!", $e->getMessage(), 500]);
        }
    }
}
