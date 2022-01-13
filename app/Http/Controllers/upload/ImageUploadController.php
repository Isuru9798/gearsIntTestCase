<?php

namespace App\Http\Controllers\upload;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ImageUploadController extends Controller
{
    function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image:jpeg,png,jpg,gif,svg'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $uploadFolder = 'books_cover';

        $image = $request->file('image');

        $image_uploaded_path = $image->store($uploadFolder, 'public');
        $imgUrl = [
            "image_url" => Storage::disk('public')->url($image_uploaded_path)
        ];
        return response()->json($imgUrl, 200);
    }
}
