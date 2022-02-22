<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Traits\Tappable;

/**
 * App\Models\Model
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Model remember($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Model query()
 * @method decrement($key, $value)
 * @mixin \Eloquent
 */
class Model extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory, Tappable, ModelHelper;

    /**
     * @var string
     */
    protected $connection = 'adminbase';

    /**
     * 能为空的字段
     *
     * @var array
     */
    protected $nullable = [];

    /**
     * 唯一组合键
     *
     * @var array
     */
    protected $unique = [];

    /**
     * Eloquent读取的时间格式
     *
     * @param \DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * 获取唯一组合键
     *
     * @return array
     */
    public function getUnique()
    {
        return $this->unique ?: [$this->primaryKey];
    }

    /**
     * 创建前过滤
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (in_array($method, ['create'])) {
            $parameters = [static::filter($parameters[0])];
        }
        return parent::__call($method, $parameters);
    }

    /**
     * 过滤掉不能为空的字段
     *
     * @param array $data
     * @return array
     */
    public function filter(array $data): array
    {
        foreach ($data as $key => $value) {
            if (is_null($value) && !in_array($key, $this->nullable)) {
                unset($data[$key]);
            }
        }
        return $data;
    }

    /**
     * Begin querying a model with eager loading.
     *
     * @param array|string $relations
     * @return \Illuminate\Database\Eloquent\Builder|static 这里补充一个注释让IDE识别
     */
    public static function with($relations)
    {
        return parent::with($relations);
    }

    /**
     * 路由绑定模型，未找到时抛出异常
     *
     * @param mixed $value
     * @param null $field
     * @return Model|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? $this->getRouteKeyName(), $value)->firstOrFail();
    }
}
