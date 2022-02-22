<?php

namespace App\Http\Requests\Api\V1\User\RefreshToken;

use App\Http\Requests\Api\V1\Request;

class IndexRequest extends Request
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
            'refresh_token' => 'required',
        ];
    }
}
