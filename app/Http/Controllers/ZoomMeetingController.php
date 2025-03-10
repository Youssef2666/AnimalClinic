<?php

namespace App\Http\Controllers;

use App\Models\ZoomMeeting;
use Illuminate\Http\Request;
use App\traits\ResponseTrait;

class ZoomMeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use ResponseTrait;
    public function index()
    {
        $zoomMeetings = ZoomMeeting::all();
        return $this->success($zoomMeetings);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
