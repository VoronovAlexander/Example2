<?php

namespace App\Http\Requests\API\users;

use Illuminate\Support\Facades\DB;

class UpdateRequest extends StoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    $user = DB::table('users')
                        ->whereEmail($value)
                        ->first();

                    if ($user && $user->id != \Request::route('user')) {
                        $fail(__('validation.unique', ['attribute' => $attribute]));
                    }
                },
            ],
            'password' => 'sometimes|nullable|string|min:6|max:255',
        ];
    }
}
