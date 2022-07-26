<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fragrance;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

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
            $fragrance = new Fragrance();
            $fragrance->name = $request->name;
            $image = Image::make($request->image)->resize(512, 512)->encode('png');
            $uuid = Str::uuid();
            $oldUuid = $fragrance->image_uuid;
            Storage::disk('s3')->put("images/fragrance/$fragrance->id/$uuid.png", $image->stream());
            $fragrance->image_uuid = $uuid;
            if ($oldUuid) {
                Storage::disk('s3')->delete("images/fragrance/$fragrance->id/$oldUuid.png");
            }
            $fragrance->save();
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
            $fragrance = Fragrance::find($request->id);
            $fragrance->description = $request->description;
            $fragrance->name = $request->name;
            $image = Image::make($request->image)->resize(512, 512)->encode('png');
            $uuid = Str::uuid();
            $oldUuid = $fragrance->image_uuid;
            Storage::disk('s3')->put("images/fragrance/$fragrance->id/$uuid.png", $image->stream());
            $fragrance->image_uuid = $uuid;
            if ($oldUuid) {
                Storage::disk('s3')->delete("images/fragrance/$fragrance->id/$oldUuid.png");
            }
            $fragrance->image_uuid = $request->image_uuid;
            $fragrance->save();
        } catch (QueryException $e) {
            return response()->json(["Something Went Wrong!", $e->getMessage(), 500]);
        }
    }
    public function delete($id)
    {
        try {
            $fragrance =  Fragrance::find($id);
            if ($fragrance) {
                $oldUuid = $fragrance->image_uuid;
                if ($oldUuid) {
                    Storage::disk('s3')->delete("images/fragrance/$fragrance->id/$oldUuid.png");
                }
                $fragrance->delete();
                return response()->json(['Data Deleted Successfully!', 200]);
            }
        } catch (QueryException $e) {
            return response()->json(["Something Went Wrong!", $e->getMessage(), 500]);
        }
    }
}
