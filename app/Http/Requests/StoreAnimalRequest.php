<?php

namespace App\Http\Requests;

use App\Enums\GenderStatus;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;


class StoreAnimalRequest extends BaseRequest
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
            'name' => 'required',
            'age' => 'required|integer',
            'weight' => 'required|numeric',
            'animal_category_id' => 'required',
            'gender' => ['required', Rule::in(array_column(GenderStatus::cases(), 'value'))],
        ];
    }
}