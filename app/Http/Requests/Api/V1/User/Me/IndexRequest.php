<?php

namespace App\Http\Requests\Api\V1\User\Me;

use App\Http\Requests\Api\V1\AuthorizeRequest;

class IndexRequest extends AuthorizeRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'uid' => 'required',
            'sub_uid' => 'required',
            'access_token' => 'required',
        ];
    }
}
