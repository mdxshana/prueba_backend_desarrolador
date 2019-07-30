<?php

namespace App\Http\Requests;

use App\Globals\KeysResponse;
use App\Globals\MessageResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
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
        if($this->method() == "POST"){
            return [
                'nombres' => 'required',
                'apellidos' => 'required',
                'email' => 'email|required|unique:users',
                'documento' => 'required|numeric|unique:users',
                'telefono' => 'required|numeric'
            ];
        }

        if($this->method() == "PUT"){
            return [
                'nombres' => 'required',
                'apellidos' => 'required',
                'email' => 'required|unique:users,email,' . $this->usuario.',id' ,
                'documento' => 'required|numeric|unique:users,documento,'. $this->usuario.',id',
                'telefono' => 'required|numeric'
            ];
        }

    }


    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json($validator->errors(),
                422
            )
        );
    }
}
