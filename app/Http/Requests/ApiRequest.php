<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

abstract class ApiRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    abstract public function rules();
    
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        if(!empty($errors)){
            $transformedError=[];
            foreach($errors as $field=>$message){
                $transformedError[]=[
                    $field => $message[0]
                ];
            }

            throw new HttpResponseException(

                response()->json(
                    [
                        'success' => false,
                        'message' => $transformedError,
                    ],
                    JsonResponse::HTTP_BAD_REQUEST
                )
            );
        }
    }
}