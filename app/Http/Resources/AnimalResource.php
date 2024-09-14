<?php

namespace App\Http\Resources;

use App\Models\AnimalCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnimalResource extends JsonResource
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
            'name' => $this->name,
            'age' => $this->age,
            'weight' => $this->weight,
            'gender' => $this->gender,
            'user' => new UserResource($this->whenLoaded('user')),
            'category' => new AnimalCategoryResource($this->whenLoaded('category')),
        ];
    }
}