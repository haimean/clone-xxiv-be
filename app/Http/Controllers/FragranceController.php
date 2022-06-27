<?php

namespace App\Http\Controllers;

use App\Models\Fragrance;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class FragranceController extends Controller
{
    public function getAll()
    {
        try {
            $data = Fragrance::get();
            return response()->json($data);
        } catch (QueryException $e) {
            return response()->json(["Something Went Wrong!", $e->getMessage(), 500]);
        }
    }
    public function store($data = [])
    {
        try {
            Fragrance::create($data);
            return response()->json(['Data Created Successfully!', 201]);
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
            $fagrance = new Fragrance();            
            $fagrance->name = $request->name;
            $fagrance->image_uuid = $request->image_uuid;
            $fagrance->save();
        } catch (QueryException $e) {
            return response()->json(["Something Went Wrong!", $e->getMessage(), 500]);
        }
    }
    public function show($id)
    {
        try {
            $data = Fragrance::find($id);
            if ($data) {
                return response()->json($data);
            } else {
                return response()->json(['Data Not found!', 404]);
            }
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
            $fagrance = Fragrance::find($request->id);
            $fagrance->description = $request->description;
            $fagrance->name = $request->name;
            $fagrance->image_uuid = $request->image_uuid;
            $fagrance->save();
        } catch (QueryException $e) {
            return response()->json(["Something Went Wrong!", $e->getMessage(), 500]);
        }
    }
    public function delete($id)
    {
        try {
            $Fragrance =  Fragrance::find($id);
            if ($Fragrance) {
                $Fragrance->delete();
                return response()->json(['Data Deleted Successfully!', 200]);
            }
        } catch (QueryException $e) {
            return response()->json(["Something Went Wrong!", $e->getMessage(), 500]);
        }
    }
}