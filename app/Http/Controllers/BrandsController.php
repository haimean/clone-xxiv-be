<?php

namespace App\Http\Controllers;

use App\Models\Brands;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class BrandsController extends Controller
{

    public function getAllBrand()
    {
        try {
            $data = Brands::get();
            return response()->json($data);
        } catch (QueryException $e) {
            return response()->json(["Something Went Wrong!", $e->getMessage(), 500]);
        }
    }
    public function store($data = [])
    {
        try {
            Brands::create($data);
            return response()->json(['Data Created Successfully!', 201]);
        } catch (QueryException $e) {
            return response()->json(["Something Went Wrong!", $e->getMessage(), 500]);
        }
    }
    public function create(Request $request)
    {
        $request->validate([
            'name' => ['string'],
            'description' => ['string'],
        ]);
        try {
            $brand = new Brands;            
            $brand->description = $request->description;
            $brand->name = $request->name;
            $brand->image_uuid = $request->image_uuid;
            $brand->save();
        } catch (QueryException $e) {
            return response()->json(["Something Went Wrong!", $e->getMessage(), 500]);
        }
    }
    public function show($id)
    {
        try {
            $data = Brands::find($id);
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
            'description' => ['string'],
        ]);

        try {
            $brand = Brands::find($request->id);
            $brand->description = $request->description;
            $brand->name = $request->name;
            $brand->image_uuid = $request->image_uuid;
            $brand->save();
        } catch (QueryException $e) {
            return response()->json(["Something Went Wrong!", $e->getMessage(), 500]);
        }
    }
    public function delete($id)
    {
        try {
            $brands =  Brands::find($id);
            if ($brands) {
                $brands->delete();
                return response()->json(['Data Deleted Successfully!', 200]);
            }
        } catch (QueryException $e) {
            return response()->json(["Something Went Wrong!", $e->getMessage(), 500]);
        }
    }
}
