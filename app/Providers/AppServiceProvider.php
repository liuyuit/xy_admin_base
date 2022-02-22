<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerHelpers();
        $this->extendValidator();
        $this->recordSql();
    }

    /**
     * 引入助手函数
     */
    protected function registerHelpers()
    {
        foreach (glob(app_path('Support/Helpers') . '/*.php') as $file) {
            require $file;
        }
    }

    /**
     * 扩展验证规则
     */
    protected function extendValidator()
    {
        // 可为空，不为空时需在表中存在
        Validator::extend(
            'exists_or_null',
            function ($attribute, $value, $parameters) {
                if ($value == 0 || is_null($value)) {
                    return true;
                } else {
                    $validator = Validator::make([$attribute => $value], [
                        $attribute => 'exists:' . implode(',', $parameters),
                    ]);
                    return !$validator->fails();
                }
            }
        );

        // 国内手机号
        Validator::extend(
            'phone',
            function ($attribute, $value) {
                return preg_match('/^(13[0-9]|15[012356789]|166|17[3678]|18[0-9]|14[57])[0-9]{8}$/', $value) === 0;
            }
        );
    }

    /**
     * 记录所有SQL（针对本地环境下，开启XDEBUG时，无法使用Telescope的场景）
     */
    protected function recordSql()
    {
        if (config('system.record_sql')) {
            \DB::listen(function ($query) {
                $sql = getSql($query);
                \Log::info(" execution time: {$query->time}ms; {$sql} \n\n\t");
            });
        }
    }

    protected function setSchema()
    {
        Schema::defaultStringLength(191);
    }
}
