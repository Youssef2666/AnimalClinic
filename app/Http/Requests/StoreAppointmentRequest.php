<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Enums\AppointmentStatus;
use App\Enums\AppointmentTypeStatus;
use App\Enums\AppointmentInterviewStatus;
use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        'user_id' => 'required|exists:users,id',
        'animal_id' => 'required|exists:animals,id',
        'date' => 'required|date',
        'time' => 'required',
        'interview' => ['required', Rule::in(array_column(AppointmentInterviewStatus::cases(), 'value'))],
        'status' => ['required', Rule::in(array_column(AppointmentStatus::cases(), 'value'))],
        'type' => ['required', Rule::in(array_column(AppointmentTypeStatus::cases(), 'value'))],
        ];
    }
}
