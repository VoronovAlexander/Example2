<?php

namespace App\Http\Requests\API\sections;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'description' => 'required|string|min:3|max:5000',
            'logo' => 'sometimes|nullable|image',
            'user_ids' => 'sometimes|array',
            'user_ids.*' => 'required|integer|min:1|exists:users,id',
        ];
    }
}
