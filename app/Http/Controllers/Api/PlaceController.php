<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\PlaceResource;
use App\Place;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(PlaceResource::collection(Place::all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);
        if ($validator->fails()){return response()->json($validator->errors(), 400);}

        $place = Place::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ]);

        return response()->json(new PlaceResource($place));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $place = Place::find($id);

        if (isset($place))
        {
            return response()->json(new PlaceResource($place));
        }
        else
        {
            return response()->json([
                'result' => 'error',
                'message' => 'Not found.'
            ],404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);
        if ($validator->fails()){return response()->json($validator->errors(), 400);}

        $place = Place::find($id);
        $place->update([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ]);

        return response()->json(new PlaceResource($place));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $place = Place::find($id);

        if (isset($place))
        {
            $place->delete();

            return response()->json(null, 204);
        }
        else
        {
            return response()->json([
                'result' => 'error',
                'message' => 'Not found.'
            ],404);
        }
    }
}
