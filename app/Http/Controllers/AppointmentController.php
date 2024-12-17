<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Appointment;
use App\Models\ZoomMeeting;
use Illuminate\Http\Request;
use App\traits\ResponseTrait;
use Jubaer\Zoom\Facades\Zoom;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Enums\AppointmentInterviewStatus;
use App\Http\Requests\StoreAppointmentRequest;

class AppointmentController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        $appointments = Appointment::with(['zoomAppointment' => function ($query) {
            $query->withoutGlobalScope('doctor_appointments');
        }])->withoutGlobalScope('user_appointments')->get();
        return $this->success($appointments, 'تم جلب المواعيد بنجاح', 200);
    }

    public function store(StoreAppointmentRequest $request)
    {
        $userId = Auth::id();
        $animalCount = Animal::where('user_id', $userId)->count();

        $date = $request->date;
        $appointmentsCount = Appointment::withoutGlobalScope('user_appointments')
            ->whereDate('date', $date)
            ->whereHas('animal', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->count();

        if ($appointmentsCount >= $animalCount) {
            return $this->error('لقد تم تجاوز حدود المواعيد في اليوم الواحد', 403);
        }

        try {
            DB::beginTransaction();
            
            $conflict = Appointment::withoutGLobalScope('user_appointments')->where('doctor_id', $request->doctor_id)
                ->where('date', $request->date)
                ->where('time', $request->time)
                ->exists();
    
            if ($conflict) {
                return $this->error('هذا الموعد محجوز بالفعل', 409);
            }

            $appointment = Appointment::create([
                'doctor_id' => $request->doctor_id,
                'animal_id' => $request->animal_id,
                'date' => $request->date,
                'time' => $request->time,
                'interview' => $request->interview,
                'status' => $request->status,
                'type' => $request->type,
            ]);

            if ($appointment->interview === AppointmentInterviewStatus::ONLINE->value) {
                $start_time = Carbon::parse($appointment->date . ' ' . $appointment->time, 'Africa/Tripoli')
                    ->format('Y-m-d\TH:i:s');

                $zoomMeeting = Zoom::createMeeting([
                    'topic' => 'Appointment for Animal ' . $appointment->animal->name,
                    'type' => 2,
                    'start_time' => $start_time,
                    'duration' => 40,
                    'timezone' => 'Africa/Tripoli',
                    'password' => 'test',
                    'agenda' => 'test',
                ]);

                $zoomData = $zoomMeeting['data'];

                $myZoom = ZoomMeeting::create([
                    'appointment_id' => $appointment->id,
                    'meeting_id' => $zoomData['id'],
                    'start_url' => $zoomData['start_url'],
                    'join_url' => $zoomData['join_url'],
                    'topic' => $zoomData['topic'],
                    'start_time' => $zoomData['start_time'],
                    'duration' => $zoomData['duration'],
                    'timezone' => $zoomData['timezone'],
                    'password' => $zoomData['password'],
                    'agenda' => $zoomData['agenda'],
                ]);

                DB::commit();

                return $this->success([$appointment, $myZoom], 'Appointment and Zoom created successfully', 201);
            }

            DB::commit();

            return $this->success($appointment, 'Appointment created successfully', 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error('حدث خطأ أثناء إنشاء الموعد', 500);
        }
    }

    public function getDoctorAppointments(string $id)
    {
        $appointments = Appointment::withoutGlobalScope('user_appointments')
            ->with(['zoomAppointment' => function ($query) {
                $query->withoutGlobalScope('doctor_appointments');
            }])
            ->where('doctor_id', $id)
            ->get();

        return $this->success($appointments);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $appointment = Appointment::with(
            ['zoomAppointment' => function ($query) {
                $query->withoutGlobalScope('doctor_appointments');
            }])->withoutGlobalScope('user_appointments')->find($id);
        return $this->success($appointment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $appointment = Appointment::withoutGlobalScope('user_appointments')->find($id);
        $appointment->update($request->all());
        return $this->success($appointment, 'تم تحديث الموعد بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
