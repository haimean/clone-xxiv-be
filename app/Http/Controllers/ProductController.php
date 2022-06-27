<?php

namespace App\Http\Controllers;

use App\Models\Brands;
use App\Models\Capacity;
use App\Models\Fragrance;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    public function getAll()
    {
        try {
            $datas = Product::get();

            foreach ($datas as $data) {
                $data->quatity = 0;
                $data->brand = Brands::find($data->brands_id)->value('name');
                $capacity =   DB::table('map_porducts_capacity')->where('id', $data->id)->get();
                foreach ($capacity as $value) {
                    $data->quatity += $value->quantity;
                }
            }
            return response()->json($datas);
        } catch (QueryException $e) {
            return response()->json(["Something Went Wrong!", $e->getMessage(), 500]);
        }
    }
    public function show($id)
    {
    
        try {
            $data = Product::find($id);
            $data->quatity = 0;
            $capacity =   DB::table('map_porducts_capacity')->where('product_id', $data->id)->get();
            foreach ($capacity as $value) {
                $value->name_capacity =  Capacity::where('id', $value->capacity_id)->value('name');
                $data->quatity += $value->quantity;
            }
            $data->capacity = $capacity;
            $data->main_scent = Fragrance::whereIn('id',DB::table('map_main_scent')->where('product_id', $data->id)->pluck('fragrance_id'))->get();
            $data->top_scent = Fragrance::whereIn('id',DB::table('map_top_scent')->where('product_id', $data->id)->pluck('fragrance_id'))->get();
            $data->middle_scent = Fragrance::whereIn('id',DB::table('map_middle_scent')->where('product_id', $data->id)->pluck('fragrance_id'))->get();
            $data->last_scent = Fragrance::whereIn('id',DB::table('map_last_scent')->where('product_id', $data->id)->pluck('fragrance_id'))->get();
            if ($data) {
                return response()->json($data);
            } else {
                return response()->json(['Data Not found!', 404]);
            }
        } catch (QueryException $e) {
            return response()->json(["Something Went Wrong!", $e->getMessage(), 500]);
        }
    }
    public function update($data = [], $id)
    {
        // try {
        //     $data = Product::find($id)->update($data);
        //     return response($data, 'Data Updated Successfully!');
        // } catch (QueryException $e) {
        //     return response("Something Went Wrong!", $e->getMessage(), 500);
        // }
    }
    public function delete($id)
    {
        try {
            $Fragrance =  Product::find($id);

            if ($Fragrance) {
                DB::table('map_porducts_capacity')->where('product_id', $id)->delete();
                DB::table('map_main_scent')->where('product_id', $id)->delete();
                DB::table('map_top_scent')->where('product_id', $id)->delete();
                DB::table('map_middle_scent')->where('product_id', $id)->delete();
                DB::table('map_last_scent')->where('product_id', $id)->delete();
                $Fragrance->delete();
                return response()->json(['Data Deleted Successfully!', 200]);
            }
        } catch (QueryException $e) {
            return response()->json(["Something Went Wrong!", $e->getMessage(), 500]);
        }
    }
}
