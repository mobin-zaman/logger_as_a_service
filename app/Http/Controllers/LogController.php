<?php

namespace App\Http\Controllers;

use App\Application;
use App\Http\Resources\ApplicationResource;
use App\Http\Resources\LogResource;
use App\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct() {
        $this->middleware('auth:api')->except(['store']);
    }

//    public function index(Request $request)

    public function index(Application $application)
    {
//        $application = Application::where(['user_id'=> $request->user()->id], ['application_id'=> $request->application_id])->firstOrFail();

//        return ApplicationResource::collection($application);
//        return LogResource::collection($application->logs());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $application = Application::where(['api_key' => $request->api_key])->firstOrFail();

        $log = Log::create([
          'application_id' => $application->id,
            'type' => ($request->type)? ($request->type): 'info',
            'description' => $request->description
        ]);
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
