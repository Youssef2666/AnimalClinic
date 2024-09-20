<?php

namespace App\Http\Resources;

use App\Enums\GenderStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => new UserResource($this->whenLoaded('user')),
            'specialization' => $this->specialization,
            'work_start_time' => $this->work_start_time,
            'work_end_time' => $this->work_end_time,
            'cost' => $this->cost,
            // 'gender' => $this->gender instanceof GenderStatus ? $this->gender->value : $this->gender,
        ];
    }
}
