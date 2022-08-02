<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{

    public function getAll()
    {
        try {
            $data = Product::get();

            foreach ($data as $datum) {
                if (Storage::exists("images/product/$datum->id/$datum->image_uuid.png")) {
                    $datum->image = Storage::url("images/product/$datum->id/$datum->image_uuid.png");
                }
                // $data->image = Storage::url("images/product/1/f5210b76-022c-4ab9-aa3f-7de59f826367.png");
                $datum->quantity = 0;
                $datum->brand;
                foreach ($datum->capacities as $value) {
                    $datum->quantity += $value->pivot->quantity;
                }
            }
            return response()->json($data);
        } catch (QueryException $e) {
            return response()->json(["Something Went Wrong!", $e->getMessage(), 500]);
        }
    }
    public function show($id)
    {
        try {
            $data = Product::find($id);
            if (Storage::url("images/product/$data->id/$data->image_uuid.png")) {
                $data->image
                    = Storage::url("images/product/$data->id/$data->image_uuid.png");
            }
            // $data->image = Storage::url("images/product/1/f5210b76-022c-4ab9-aa3f-7de59f826367.png");
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
    public function update(Request $request)
    {
        try {
            $product = Product::find($request->id);
            $product->content = $request->content;
            $product->brands_id = $request->brands_id;
            $product->age = $request->age;
            $product->day = $request->day;
            $product->description = $request->description;
            $product->fall = $request->fall;
            $product->night = $request->night;
            $product->sex = $request->sex;
            $product->spring = $request->spring;
            $product->summer = $request->summer;
            $product->time_smell = $request->time_smell;
            $product->title = $request->title;
            $product->winter = $request->winter;
            $product->published_at = $request->published_at;
            $capacities = [];
            $image = Image::make($request->image)->resize(512, 512)->encode('png');
            $uuid = Str::uuid();
            $oldUuid = $product->image_uuid;
            Storage::disk('s3')->put("images/product/$product->id/$uuid.png", $image->stream());
            $product->image_uuid = $uuid;
            if ($oldUuid) {
                Storage::disk('s3')->delete("images/product/$product->id/$oldUuid.png");
            }
            foreach ($request->capacities as  $value) {
                array_push($capacities, $value['id']);
            }
            $product->capacities()->sync($capacities);
            foreach ($request->capacities as  $value) {
                $product->capacities()->updateExistingPivot($value['id'], ['price' => $value['pivot']['price'], 'quantity' => $value['pivot']['quantity']]);
            }
            $main_scent = [];
            $top_scent = [];
            $middle_scent = [];
            $last_scent = [];
            foreach ($request->main_scent as  $value) {
                array_push($main_scent, $value['id']);
            }
            foreach ($request->top_scent as  $value) {
                array_push($top_scent, $value['id']);
            }
            foreach ($request->middle_scent as  $value) {
                array_push($middle_scent, $value['id']);
            }
            foreach ($request->last_scent as  $value) {
                array_push($last_scent, $value['id']);
            }
            $product->main_scent()->sync($main_scent);
            $product->main_scent()->sync($top_scent);
            $product->main_scent()->sync($middle_scent);
            $product->main_scent()->sync($last_scent);
            $product->save();
            return response()->json('Update Successfully!', 200);
        } catch (QueryException $e) {
            return response()->json(["Something Went Wrong!", $e->getMessage()], 500);
        }
    }

    public function create(Request $request)
    {
        try {
            $product = new Product();
            $product->content = $request->content;
            $product->brands_id = $request->brands_id;
            $product->age = $request->age;
            $product->day = $request->day;
            $product->description = $request->description;
            $product->fall = $request->fall;
            $product->night = $request->night;
            $product->sex = $request->sex;
            $product->spring = $request->spring;
            $product->summer = $request->summer;
            $product->time_smell = $request->time_smell;
            $product->title = $request->title;
            $product->winter = $request->winter;
            $product->published_at = $request->published_at;
            $product->image_uuid = 'IMAGE';
            $image = Image::make($request->file('image'))->resize(256, 256)->encode('png');
            $uuid = Str::uuid();
            $oldUuid = $product->image_uuid;
            Storage::put("images/product/$product->id/$uuid.png", $image->stream());
            $product->image_uuid = $uuid;
            if ($oldUuid) {
                Storage::delete("images/product/$product->id/$oldUuid.png");
            }
            $product->save();
            foreach ($request->capacities as  $value) {
                $product->capacities()->attach($value['id'], ['product_id' => $product['id'], 'price' => $value['pivot']['price'], 'quantity' => $value['pivot']['quantity']]);
            }
            foreach ($request->main_scent as  $value) {
                $product->main_scent()->attach($value['id']);
            }
            foreach ($request->top_scent as  $value) {
                $product->top_scent()->attach($value['id']);
            }
            foreach ($request->last_scent as  $value) {
                $product->last_scent()->attach($value['id']);
            }
            foreach ($request->middle_scent as  $value) {
                $product->middle_scent()->attach($value['id']);
            }
            $product->save();
            return response()->json('Create Successfully!', 200);
        } catch (QueryException $e) {
            return response()->json(["Something Went Wrong!", $e->getMessage()], 500);
        }
    }
    public function delete($id)
    {
        try {
            $product =  Product::find($id);

            if ($product) {
                $oldUuid = $product->image_uuid;
                if ($oldUuid) {
                    Storage::disk('s3')->delete("images/product/$product->id/$oldUuid.png");
                }
                DB::table('map_products_capacity')->where('product_id', $id)->delete();
                DB::table('map_main_scent')->where('product_id', $id)->delete();
                DB::table('map_top_scent')->where('product_id', $id)->delete();
                DB::table('map_middle_scent')->where('product_id', $id)->delete();
                DB::table('map_last_scent')->where('product_id', $id)->delete();
                $product->delete();
                return response()->json(['Data Deleted Successfully!', 200]);
            }
        } catch (QueryException $e) {
            return response()->json(["Something Went Wrong!", $e->getMessage(), 500]);
        }
    }
}
