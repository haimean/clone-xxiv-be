<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Brands;
use Illuminate\Database\QueryException;

class BrandController extends Controller
{

    public function getAllBrand()
    {
        try {
            $datas = Brands::get();
            foreach ($datas as $data) {
                $data->logo = ' https://xxivstore.com/wp-content/uploads/2021/01/afnan.png';
            }
            return response()->json($datas);
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
    public function show($id)
    {
        try {
            $data = Brands::find($id);
            if ($data) {
                $data->logo = ' https://xxivstore.com/wp-content/uploads/2021/01/afnan.png';
                return response()->json($data);
            } else {
                return response()->json(['Data Not found!', 404]);
            }
        } catch (QueryException $e) {
            return response()->json(["Something Went Wrong!", $e->getMessage(), 500]);
        }
    }
}
