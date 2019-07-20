<?php

namespace App\Http\Requests\API\sections;

class UpdateRequest extends StoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();

        return array_merge($rules, [
            // 'id' => 'required|integer|min:1|exists:sections,id',
        ]);
    }
}
