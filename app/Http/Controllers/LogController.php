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
     */

    public function __construct() {
        $this->middleware('auth:api')->except(['store']);
        $this->middleware('cors');
    }

//    public function index(Request $request)

    public function index(Request $request)
    {

        $application = Application::where(['id'=>$request->route('application_id'),'user_id'=> $request->user()->id])->firstOrFail();

        return LogResource::collection(Log::where(['application_id'=>$request->route('application_id')])->orderBy('id','DESC')->get());
    }

    public function get_log_count(Request $request) {
        $application = Application::where(['id'=>$request->route('application_id'),'user_id'=> $request->user()->id])->firstOrFail();
        $count =  Log::where(['application_id'=>$request->route('application_id')])->count();
        return response()->json([
            'log_count' => $count
        ]);
    }

    public function get_latest_logs(Request $request) {
        $application = Application::where(['id'=>$request->route('application_id'),'user_id'=> $request->user()->id])->firstOrFail();
        $logs =  Log::where(['application_id'=>$request->route('application_id')])->latest()->take($request->route('count'))->orderBy('id', 'DESC')->get();
        return LogResource::collection($logs);
    }

    public function get_log_by_id(Request $request){
        $application = Application::where(['id'=>$request->route('application_id'),'user_id'=> $request->user()->id])->firstOrFail();
        $logs =  Log::where(['id'=>$request->route('id')])->get();
        return LogResource::collection($logs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $application = Application::where('api_key', 'LIKE', "%{$request->api_key}")->firstOrFail();
        $application = Application::whereRaw("BINARY `api_key` = ?", [$request->api_key])->firstOrFail();



        $log = Log::create([
          'application_id' => $application->id,
            'type' => ($request->type)? ($request->type): 'info',
            'description' => $request->description
        ]);
    }

//    /**
//     * Display the specified resource.
//     *
//     * @param  int  $id
//     * @return \Illuminate\Http\Response
//     */
//    public function show($id)
//    {
//        //
//    }

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
