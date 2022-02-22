<?php

use Illuminate\Database\Query\Expression;

if (!function_exists('getUpdatedAtDefault')) {
    /**
     * 获取Migration中更新时间的默认值表达式
     *d
     * @return Expression
     */
    function getUpdatedAtDefault(): Expression
    {
        return DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP');
    }
}

if (!function_exists('setTableComment')) {
    /**
     * 设置表注释
     *
     * @param string $className
     * @param string $comment
     */
    function setTableComment(string $className, string $comment)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $tableName = $className::table();
        /** @noinspection SqlDialectInspection */
        DB::statement("ALTER TABLE `$tableName` comment '$comment'");
    }
}

if (!function_exists('getSql')) {
    /**
     * 获取查询的SQL语句
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Events\QueryExecuted|array $query
     * @return string
     */
    function getSql($query): string
    {
        if ($query instanceof \Illuminate\Database\Query\Builder ||
            $query instanceof \Illuminate\Database\Eloquent\Builder) {
            $sql = $query->toSql();
            $bindings = $query->getBindings();
        } elseif ($query instanceof \Illuminate\Database\Events\QueryExecuted) {
            $sql = $query->sql;
            $bindings = $query->bindings;
        } else {
            $sql = $query['query'];
            $bindings = $query['bindings'];
            if ($bindings && !is_array($bindings)) {
                $bindings = [$bindings];
            }
        }

        $bindings = array_map(function ($binding) {
            if ($binding instanceof DateTime) {
                return $binding->format('Y-m-d H:i:s');
            }
            return $binding;
        }, $bindings);

        $sql = str_replace('%', '738f5f04754755e973f74e966d73c5', $sql);
        $sql = str_replace('?', '"%s"', $sql);
        $sql = vsprintf($sql, $bindings);
        $sql = str_replace('738f5f04754755e973f74e966d73c5', '%', $sql);

        return $sql;
    }
}
