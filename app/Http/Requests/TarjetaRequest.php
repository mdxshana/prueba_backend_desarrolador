<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use LVR\CreditCard\CardCvc;
use LVR\CreditCard\CardNumber;

class TarjetaRequest extends FormRequest
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
            "numero_tarjeta" => ['required',new CardNumber],
            "vencimiento" => "required",
            "cvc" => ['required',new CardCvc($this->get('numero_tarjeta'))]
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
