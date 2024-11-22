<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Models\AnimalCategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class AnimalResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'age' => $this->age,
            'weight' => $this->weight,
            'gender' => $this->gender,
            'animal_type' => $this->animal_type,
            'image_url' => $this->image ? url(Storage::url($this->image)) : null,
            'user' => new UserResource($this->whenLoaded('user')),
            'category' => new AnimalCategoryResource($this->whenLoaded('category')),
            'appointments' => $this->whenLoaded('appointments'),
        ];
    }
}