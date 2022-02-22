<?php

namespace App\Http\Requests;

trait HasJsonBody
{
    /**
     * 将请求体的json作为验证对象
     *
     * @param null $keys
     * @return array
     */
    public function all($keys = null): array
    {
        $input = parent::all($keys);
        $json = empty($keys) ? parent::json()->all() : collect(parent::json()->all())->only($keys)->toArray();
        return array_merge($input, $json);
    }
}
