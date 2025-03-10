<?php

namespace App\Http\Controllers;

use Jubaer\Zoom\Facades\Zoom;

class ZoomController extends Controller
{
    public function index()
    {
        $dateinHour = now()->addHour();
        $start_time = $dateinHour->format('Y-m-d\TH:i:s\Z');
        $meeting = Zoom::createMeeting([
            'topic' => 'Appointment for Doctor Mohamed',
            'type' => 2,
            'start_time' => $start_time,
            'duration' => 40,
            'timezone' => 'Africa/Tripoli',
            'password' => 'test',
            'agenda' => 'test',
        ]);
        return $meeting;
    }
}
