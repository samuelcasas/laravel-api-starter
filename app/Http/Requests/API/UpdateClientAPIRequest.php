<?php

namespace App\Http\Requests\API;

use App\Models\Client;
use Dingo\Api\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UpdateClientAPIRequest extends FormRequest
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
    public function rules(Request $request)
    {
        $rules = Client::$rules;

        $rules['prefix'] = [
            'required',
            Rule::unique('clients')->ignore($request->user('api')->id, 'user_id')
        ];

        return $rules;
    }
}
