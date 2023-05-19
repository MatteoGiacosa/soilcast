<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreZoneRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'connected' => 'required|boolean',
            'battery' => 'required|numeric',
            'humidityPercentage' => 'required|numeric',
            'latestDataCollection' => 'required|date_format:H:i:s',
            'control_unit_id' => 'required|exists:control_units,id',
            'zoneName' => 'required|exists:zones,zoneName',
        ];
    }
}
