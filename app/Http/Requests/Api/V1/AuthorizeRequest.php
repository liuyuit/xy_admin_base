<?php

namespace App\Http\Requests\Api\V1;

use App\Models\User\User;
use App\Services\User\Token\Token;

class AuthorizeRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $tokenService = new Token();
        return $tokenService->checkUid($this->access_token, $this->uid);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            //
        ];
    }

    /**
     * Get the user making the request.
     *
     * @param  string|null  $guard
     * @return User
     */
    public function user($guard = null): User
    {
        if ($user = parent::user($guard)) {
            return $user;
        }

        $accessToken = $this->header('Access-Token');
        $tokenService = new Token();
        $user = $tokenService->getUser($accessToken);

        return $user;
    }
}
