<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ActivityRequest extends FormRequest
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
            'user_id' => ['required'],
            'start_date' => ['required', Rule::date()->format('Y-m-d')],
            'type' => ['required', 'min:2', 'max:20'],
            'sub_type_1' => ['min:2', 'max:20'],
            'sub_type_2' => ['min:2', 'max:20'],
            'sub_type_3' => ['min:2', 'max:20'],
            'number_of_sets_1' => ['integer', 'between:1,12'],
            'number_of_sets_2' => ['integer', 'between:1,12'],
            'number_of_sets_3' => ['integer', 'between:1,12'],
            'number_of_reps_1' => ['integer', 'between:1,1000'],
            'number_of_reps_2' => ['integer', 'between:1,1000'],
            'number_of_reps_3' => ['integer', 'between:1,1000'],
            'weight_1' => ['decimal:0,2', 'between:1,1000'],
            'weight_2' => ['decimal:0,2', 'between:1,1000'],
            'weight_3' => ['decimal:0,2', 'between:1,1000'],
            'distance' => ['decimal:0,2', 'between:1,1000000'],
        ];
    }
}
