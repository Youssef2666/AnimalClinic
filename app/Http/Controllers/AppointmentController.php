<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use App\Models\Appointment;
use App\Models\ZoomMeeting;
use Illuminate\Http\Request;
use Jubaer\Zoom\Facades\Zoom;
use App\Enums\AppointmentInterviewStatus;
use App\Http\Requests\StoreAppointmentRequest;
use App\traits\ResponseTrait;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        $appointments = Appointment::with('zoomAppointment')->get();
        return $this->success($appointments, 'Appointments retrieved successfully', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppointmentRequest $request)
    {
        // Create the appointment
        $appointment = Appointment::create([
        'user_id' => $request->user_id,
        'animal_id' => $request->animal_id,
        'date' => $request->date,
        'time' => $request->time,
        'interview' => $request->interview,
        'status' => $request->status,
        'type' => $request->type,
        ]);
        // Check if the appointment type is online (Zoom)
    if ($appointment->interview === AppointmentInterviewStatus::ONLINE->value) {
        $start_time = Carbon::parse($appointment->date . ' ' . $appointment->time, 'Africa/Tripoli')
        ->format('Y-m-d\TH:i:s');

        // Create the Zoom meeting
        $zoomMeeting = Zoom::createMeeting([
            'topic' => 'Appointment for Animal ' . $appointment->animal->name,
            'type' => 2, // Scheduled meeting
            'start_time' => $start_time,
            'duration' => 40, // in minutes
            'timezone' => 'Africa/Tripoli',
            'password' => 'test',
            'agenda' => 'test',
        ]);

        // Save Zoom meeting details into the zoom_meetings table
        $zoomData = $zoomMeeting['data']; // Access the 'data' key

        $myZoom = ZoomMeeting::create([
            'appointment_id' => $appointment->id,
            'meeting_id' => $zoomData['id'], // Extract 'id' from 'data'
            'start_url' => $zoomData['start_url'],
            'join_url' => $zoomData['join_url'],
            'topic' => $zoomData['topic'],
            'start_time' => $zoomData['start_time'],
            'duration' => $zoomData['duration'],
            'timezone' => $zoomData['timezone'],
            'password' => $zoomData['password'],
            'agenda' => $zoomData['agenda'],
        ]);
        return $this->success([$appointment, $myZoom ], 'Appointment and Zoom created successfully', 201);
    }
        return $this->success($appointment, 'Appointment created successfully', 201);
    }

    public function getDoctorAppointments(string $id){
        $appointments = Appointment::with('zoomAppointment')->where('user_id', $id)->get();
        return $this->success($appointments);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return ZoomMeeting::all();
        $appointment = Appointment::with('zoomAppointment')->find($id);
        return $this->success($appointment);
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
