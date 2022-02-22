<?php

namespace App\Models;

/**
 * Trait ModelHelper
 * @method \Illuminate\Database\Connection getConnection()
 * @package App\Models
 */
trait ModelHelper
{
    /**
     * 获取表名
     *
     * @param bool $withConnection
     * @return string
     */
    public static function table($withConnection = false): string
    {
        $instance = new static();
        $table = $instance->getTable();
        $connectionName = $instance->getConnectionName();
        return $withConnection ? "{$connectionName}.{$table}" : $table;
    }

    /**
     * 带别名的表名
     *
     * @param $aliasName
     * @return string
     */
    public static function alias($aliasName): string
    {
        $table = static::table(true);
        return "$table AS $aliasName";
    }

    /**
     * 带索引建议的表名
     *
     * @param $indexName
     * @param string $aliasName
     * @return string
     */
    public static function index($indexName, $aliasName = ''): string
    {
        $table = $aliasName ? static::alias($aliasName) : static::table(true);
        return \DB::raw("$table USE INDEX ($indexName)");
    }

    /**
     * 获取前一句sql执行的结果数
     *
     * @return int
     */
    public static function getFoundRows(): int
    {
        $sql = 'SELECT FOUND_ROWS() AS found_rows';
        $result = static::selectSql($sql);
        return $result[0]['found_rows'];
    }

    /**
     * 直接执行sql，返回结果集
     *
     * @param $sql
     * @return array
     */
    public static function selectSql($sql): array
    {
        return (new static())->getConnection()->select($sql);
    }

    /**
     * 直接执行sql，返回布尔结果
     *
     * @param $sql
     * @return bool
     */
    public static function statement($sql): bool
    {
        return (new static())->getConnection()->statement($sql);
    }

    /**
     * 执行事务 注意需要connection属性有值的子类才能执行
     *
     * @param \Closure $callback
     * @return mixed 回调方法的返回值，注意没返回值将无法判断事务是否成功
     * @throws \Throwable
     */
    public static function transaction(\Closure $callback)
    {
        return (new static())->getConnection()->transaction($callback);
    }
}
