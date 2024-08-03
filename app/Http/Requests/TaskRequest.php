<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class TaskRequest extends FormRequest
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
            'title' => 'required|string|max:100',
            'user_id' => 'required',
            'start_at' => 'required|date',
            'end_at' => 'required|date'
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'A title is required',
            'title.string' => 'A title must to be string',
            'title.max' => 'A title has max 100 character',
            'user_id.required' => 'A id of user is required',
            'start_at.required' => 'A start date of task is required',
            'start_at.date' => 'A start date of task must to be datetime',
            'end_at.required' => 'A end date of task is required',
            'start_at.date' => 'A start date of task must to be datetime'
        ];
    }

    public function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(response()->json([

            'status'   => 422001,

            'message'   => 'Validation errors',

            'errors'      => $validator->errors()

        ]));

    }
}
