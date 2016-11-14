<?php

namespace App\Http\Requests\API;

use App\Models\Telephone;
use Dingo\Api\Http\FormRequest;

class CreateTelephoneAPIRequest extends FormRequest
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
        return Telephone::$rules;
    }
}
