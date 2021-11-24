<?php

namespace App\Http\Controllers;

use App\Models\PetImage;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PetImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $petImages = PetImage::with(['user', 'likes.user', 'comments.user'])
                                ->orderBy('created_at', 'DESC')
                                ->get();

            return response()->json([
                'success' => true,
                'images' => $petImages
            ]);

        } catch(\Throwable $e){
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
        
        
    }

    public function userImages(Request $request)
    {
        try {
            $petImages = PetImage::with(['user', 'likes.user', 'comments.user'])
                                ->where('user_id', $request->user()->id)
                                ->orderBy('created_at', 'DESC')
                                ->get();

            return response()->json([
                'success' => true,
                'images' => $petImages
            ]);

        } catch(\Throwable $e){
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
        
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $userId = $request->user()->id;

            $imagePath = $request->file('image')->store('images', 's3');
            $petImage = PetImage::create([
                'url' => env('AWS_URL') . "/$imagePath",
                'user_id' => $userId
            ]);

            return response()->json([
                'success' => true,
                'data' => $petImage
            ]);

        } catch (\Throwable $e){
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);

        }
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PetImage  $petImage
     * @return \Illuminate\Http\Response
     */
    public function show(PetImage $petImage, Request $request)
    {
        return response()->json([
            'success' => true,
            'petImage' => $petImage->load(['user', 'likes.user', 'comments.user'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PetImage  $petImage
     * @return \Illuminate\Http\Response
     */
    public function edit(PetImage $petImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PetImage  $petImage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PetImage $petImage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PetImage  $petImage
     * @return \Illuminate\Http\Response
     */
    public function destroy(PetImage $petImage, Request $request)
    {
        if ($petImage->user_id != $request->user()->id){
            return response()->json([
                'success' => false,
                'error' => "You are not allowed to delete someone else's pet photos. How rude of you!"
            ]);
        }

        $image = PetImage::find($petImage->id);
        $image->comments()->delete();
        $image->likes()->delete();
        $image->delete();

        return response()->json([
            'success' => true,
            'message' => 'Photo deleted.'
        ]);
    }
}
