<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use App\Models\PetImage;
use Illuminate\Support\Facades\Log;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(PetImage $petImage, Request $request)
    {
        try {
            $like = Like::create([
                'pet_image_id' => $petImage->id,
                'user_id' => $request->user()->id
            ]);

            return response()->json([
                'success' => true,
                'like' => $like
            ]);

        } catch(\Throwable $e){
           return response()->json([
               'success' => false,
               'error' => $e->getMessage()
           ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function show(Like $like)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function edit(Like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PetImage $petImage
     * @return \Illuminate\Http\Response
     */
    public function destroy(PetImage $petImage, Request $request)
    {
        try {
            Like::where('user_id', $request->user()->id)
                    ->where('pet_image_id', $petImage->id)
                    ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Photo has been unliked.'
            ]);

        } catch(\Throwable $e){
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'error' => "Unable to dislike image."
            ]);
        }
          
    }
}
