<?php

namespace App\Http\Controllers;

use App\Application;
use App\Http\Resources\ApplicationResource;
use Hidehalo\Nanoid\Client;
use Illuminate\Http\Request;
use Validator;

class ApplicationController extends Controller
{

    public function __construct() {
        $this->middleware('auth:api');
    }


    public function index()
    {
        return ApplicationResource::collection(Application::all());
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name'=>'required',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $application_with_same_name = Application::where('name', $request->name)->first();


        if($application_with_same_name != null) {
           return response()->json(['error'=>'there is already an application with that name: '.$request->name],409);
        }

        $nano_id_client = new Client();

        $application = Application::create([
           'user_id' => $request->user()->id,
           'name' => $request->name,
           'description'=> $request->description,
           'api_key' => $nano_id_client->generateId().$nano_id_client->generateId()
       ]);

        return new ApplicationResource($application);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
