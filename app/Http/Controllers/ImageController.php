<?php

namespace App\Http\Controllers;

ini_set('max_execution_time', 600);

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Use the all() method to get all records from images table
        $images = Image::all();

        return response()->json($images);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|string|max:255',
        ]);

        // Create a new Image instance and set its properties
        $image = new Image();
        $image->name = $validatedData['name'];
        $image->url = $validatedData['url'];
        $image->requestCount = 0;

        // Get the maximum id value from the existing images
        $maxId = Image::max('id');

        // Set the new image's id and page values
        $image->id = $maxId + 1;
        $image->page = ceil($maxId / 9);

        // Save the new image to the database
        $image->save();

        // Return a success response
        return response()->json([
            'message' => 'Image created successfully',
            'image' => $image,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        //
    }

    // Here is the route for this function, in api.php
    // Route::get('/meme/id/{id}', [App\Http\Controllers\ImageController::class, 'getImageById']);
    // localhost:8000/api/meme/id/1
    public function getImageByID($id)
    {
        $image = Image::Find($id);
        $image->requestCount += 1; // increment the requestCount by 1
        $image->save(); // save the updated image model to the database

        return response()->json($image);
    }

    // Here is the route for this function, in api.php
    // Route::get('/meme/page/{page}', [App\Http\Controllers\ImageController::class, 'getImageByPage']);
    // localhost:8000/api/meme/page/1
    public function getImageByPage($page)
    {

        $images = Image::where('page', $page)->get();

        foreach ($images as $image) {
            $image->requestCount += 1; // increment the requestCount by 1
            $image->save(); // save the updated image model to the database
        }

        return response()->json($images);
    }

    public function getMostPopularImage()
    {
        $image = Image::orderBy('requestCount', 'desc')->first();

        return response()->json([$image]);
    }

    public function showAllImages()
    {
        $images = Image::all(); // using Eloquent model
        $images = Image::paginate(9);

        if ($images->isEmpty()) {
            return 'No images found.';
        }

        foreach ($images as $image) {
            $fileName = basename(parse_url($image->url, PHP_URL_PATH));
            $imageUrl = asset('images/' . $fileName);
            // $image = [
            //     'url' => $imageUrl,
            //     'fileName' => $fileName,
            // ];
            $image->url = $imageUrl;
            $image->fileName = $fileName;
        }

        // $images = Image::paginate(12);

        // Return a view with your data
        return view('showImages', compact('images'));
    }

    public function downloadAllImages()
    {
        $directory = public_path('images');

        if (!File::exists($directory)) {
            File::makeDirectory($directory);
        }

        $images = Image::all();

        foreach ($images as $image) {
            $contents = file_get_contents($image->url);
            $fileName = basename(parse_url($image->url, PHP_URL_PATH));

            $savePath = public_path('images/' . $fileName);

            file_put_contents($savePath, $contents);
        }
    }

    public function changeName()
    {
        $images = Image::all();

        foreach ($images as $image) {
            $fileName = basename(parse_url($image->url, PHP_URL_PATH));

            $image->update([
                'name' => $fileName,
            ]);
        }
    }
}
