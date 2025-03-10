<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicalRecordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'notes' => $this->notes,
            'animal' => new AnimalResource($this->whenLoaded('animal')),
            'medicines' => $this->whenLoaded('medicines'),
            'surgeries' => $this->whenLoaded('surgeries'),
            'vaccinations' => $this->whenLoaded('vaccinations'),
        ];
    }
}
