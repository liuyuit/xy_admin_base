<?php

namespace App\Casts;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class DateTime implements CastsAttributes
{
    /**
     *  将取出的数据进行转换
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  string|null  $value
     * @param  array  $attributes
     * @return false|int
     */
    public function get($model, $key, $value, $attributes)
    {
        if ($value === null) {
            return null;
        }
        return strtotime($value);
    }

    /**
     * 转换成将要进行存储的值
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  int|null  $value
     * @param  array  $attributes
     * @return string
     */
    public function set($model, $key, $value, $attributes)
    {
        if (!$value) {
            return $value;
        }

        if (!is_numeric($value)) {
            return $value;
        }


        return Carbon::createFromTimestamp($value)->toDateTimeString();
    }
}
