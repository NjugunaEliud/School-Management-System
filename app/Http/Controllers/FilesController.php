<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Files;
use App\Http\Requests\FilesRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{
    public function store(FilesRequest $request)
    {
        try {
            $imageName = Str::random(32).".".$request->image->getClientOriginalExtension();
     
            // Create Post
           Files::create([
                'name' => $request->name,
                'image' => $imageName,
                'description' => $request->description
            ]);
     
            // Save Image in Storage folder
            Storage::disk('public')->put($imageName, file_get_contents($request->image));
     
            // Return Json Response
            return response()->json([
                'message' => "Post successfully created."
            ],200);
        } catch (\Exception $e) {
            // Return Json Response
            return response()->json([
                'message' => "Something went really wrong!"
            ],500);
        }
    }
}
