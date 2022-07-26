<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brands;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class BrandController extends Controller
{

    public function getAllBrand()
    {
        try {
            $data = Brands::get();
            foreach ($data as $datum) {
                $datum->logo = 'https://xxivstore.com/wp-content/uploads/2021/01/logo-ACQUAdiPARMA_prova.png';
                $datum->background = "https://xxivstore.com/wp-content/uploads/2021/03/nuoc-hoa-Afnan.jpg";
            }

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
        ]);
        try {
            $brand = new Brands;
            $brand->description = $request->description;
            $brand->name = $request->name;
            $image = Image::make($request->logo)->resize(512, 512)->encode('png');
            $uuidLogo = Str::uuid();
            $oldUuidLogo = $brand->logo_uuid;
            Storage::disk('s3')->put("images/brand/$brand->id/logo/$uuidLogo.png", $image->stream());
            $brand->logo_uuid = $uuidLogo;
            if ($oldUuidLogo) {
                Storage::disk('s3')->delete("images/brand/$brand->id/logo/$oldUuidLogo.png");
            }
            $background = Image::make($request->background)->resize(256, 256)->encode('png');
            $uuidBackground = Str::uuid();
            $oldUuidBackground = $brand->background_uuid;
            Storage::disk('s3')->put("images/brand/$brand->id/background/$uuidBackground.png", $background->stream());
            $brand->background_uuid = $uuidBackground;
            if ($oldUuidBackground) {
                Storage::disk('s3')->delete("images/brand/$brand->id/background/$oldUuidBackground.png");
            }
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
                $data->logo = 'https://xxivstore.com/wp-content/uploads/2021/01/logo-ACQUAdiPARMA_prova.png';
                $data->background = "https://xxivstore.com/wp-content/uploads/2021/03/nuoc-hoa-Afnan.jpg";
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
            $image = Image::make($request->logo)->resize(512, 512)->encode('png');
            $uuidLogo = Str::uuid();
            $oldUuidLogo = $brand->logo_uuid;
            Storage::disk('s3')->put("images/brand/$brand->id/logo/$uuidLogo.png", $image->stream());
            $brand->logo_uuid = $uuidLogo;
            if ($oldUuidLogo) {
                Storage::disk('s3')->delete("images/brand/$brand->id/logo/$oldUuidLogo.png");
            }
            $background = Image::make($request->background)->resize(256, 256)->encode('png');
            $uuidBackground = Str::uuid();
            $oldUuidBackground = $brand->background_uuid;
            Storage::disk('s3')->put("images/brand/$brand->id/background/$uuidBackground.png", $background->stream());
            $brand->background_uuid = $uuidBackground;
            if ($oldUuidBackground) {
                Storage::disk('s3')->delete("images/brand/$brand->id/background/$oldUuidBackground.png");
            }
            $brand->save();
        } catch (QueryException $e) {
            return response()->json(["Something Went Wrong!", $e->getMessage(), 500]);
        }
    }
    public function delete($id)
    {
        try {
            $brand =  Brands::find($id);
            if ($brand) {
                $oldUuidBackground = $brand->background_uuid;
                $oldUuidLogo = $brand->logo_uuid;
                if ($oldUuidBackground) {
                    Storage::disk('s3')->delete("images/product/$brand->id/$oldUuidBackground.png");
                }
                if ($oldUuidLogo) {
                    Storage::disk('s3')->delete("images/product/$brand->id/$oldUuidLogo.png");
                }
                $brand->delete();
                return response()->json(['Data Deleted Successfully!', 200]);
            }
        } catch (QueryException $e) {
            return response()->json(["Something Went Wrong!", $e->getMessage(), 500]);
        }
    }
}
