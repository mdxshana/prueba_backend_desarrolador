<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class PersonaRequest extends FormRequest
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
        $request = $this->request;
        if($this->method() == "POST"){
            return [
                'nombres' => 'required|string|max:100',
                'apellidos' => 'required|string|max:100',
                'email' => 'email|required|max:120',
                'n_documento' => [
                    Rule::unique('personas')->where(function ($query) use($request) {
                        return $query->where('tipo_documento_id', $request->get('tipo_documento_id'));
                    }),
                    'required',
                    'numeric',
                    'digits_between:3,10'
                ],
                'tipo_documento_id' => 'required|exists:tipo_documentos,id',
                'direccion' => 'required|string|max:150',
                'telefono' => 'required|numeric|digits_between:3,10'
            ];
        }

        if($this->method() == "PUT"){
            return [
                'email' => 'required|email|max:120' ,
                'n_documento' => [
                    Rule::unique('personas')->where(function ($query) use($request) {
                        return $query->where('tipo_documento_id', $request->get('tipo_documento_id'));
                    })->ignore($this->persona),
                    'required',
                    'numeric',
                    'max:9999999999'
                ],
                'nombres' => 'required|string|max:100',
                'apellidos' => 'required|string|max:100',
                'tipo_documento_id' => 'required|exists:tipo_documentos,id',
                'direccion' => 'required|string|max:150',
                'telefono' => 'required|numeric|digits_between:3,10'
            ];
        }

    }

    public function attributes()
    {
        return [
          'n_documento' => 'El numero de docuemnto',
           'tipo_documento_id' => "El tipo de documento"
        ];
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
