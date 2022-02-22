<?php

namespace App\Http\Requests\Api\V1;

use App\Http\Requests\HasJsonBody;
use Illuminate\Contracts\Validation\Validator;
use App\Exceptions\Api\ValidationException;
use App\Exceptions\Api\UnauthorizedException;
use Illuminate\Foundation\Http\FormRequest;

class Request extends FormRequest
{
    use HasJsonBody;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator->errors()->first());
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\UnauthorizedException
     */
    protected function failedAuthorization()
    {
        throw new UnauthorizedException;
    }
}
