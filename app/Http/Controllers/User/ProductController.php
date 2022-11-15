<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function getAll()
    {
        try {
            $datas = Product::get();

            foreach ($datas as $data) {
                $data->image = "https://xxivstore.com/wp-content/uploads/2022/07/Nuoc-hoa-chinh-hang-9AM-300x300.png";
                // $id = $data->id;
                // $image_uuid = $data->image_uuid;
                // if (Storage::url("xxiv-clone/images/product/$id/$image_uuid.png")) {
                // } else {
                // $data->image = Storage::url("xxiv-clone/images/product/$id/$image_uuid.png");
                // }  summer spring winter fall
                if ($data->summer > $data->spring) {
                    $data->season = 'summer';
                }
                if ($data->spring > $data->winter) {
                    $data->season = 'spring';
                }
                if ($data->winter > $data->fall) {
                    $data->season = 'winter';
                }
                if ($data->fall > $data->summer) {
                    $data->season = 'fall';
                }
                $data->brand;
                foreach ($data->capacities as $capacitie) {
                    if ($capacitie->pivot->price > $data->price) {
                        $data->price = $capacitie->pivot->price;
                    }
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
            // if (Storage::url("images/product/$data->id/$data->image_uuid.png")) {
            // $data->image
            // = Storage::url("images/product/$data->id/$data->image_uuid.png");
            // }
            $data->price = 0;
            foreach ($data->capacities as $capacitie) {
                if ($capacitie->pivot->price > $data->price) {
                    $data->price = $capacitie->pivot->price;
                }
            }
            $data->image = "https://xxivstore.com/wp-content/uploads/2022/07/Nuoc-hoa-chinh-hang-9AM-300x300.png";
            $data->brand;
            $data->capacities;
            $data->main_scent;
            $data->top_scent;
            $data->middle_scent;
            $data->last_scent;
            if ($data) {
                return response()->json($data);
            } else {
                return response()->json(['Data Not found!', 404]);
            }
        } catch (QueryException $e) {
            return response()->json(["Something Went Wrong!", $e->getMessage(), 500]);
        }
    }
}
