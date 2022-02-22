<?php

namespace App\Console\Commands\Make;

use Illuminate\Console\Command;

class MakeApi extends Command
{
    /**
     *  php artisan api:template User/Test/ApiTest
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:api
                            {path : The path of controller}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate templates regarding api';

    protected $footerPath; // Controller 文件尾部的路径， 例如 App/Http/Controllers/Api/V1/User/LoginController.php 的  $footerPath 就是 User/Login
    protected $controllerNamespace = 'App\Http\Controllers\Api\V1\%s'; // App\Http\Controllers\Api\V1\User
    protected $requestUse = 'use App\Http\Requests\Api\V1\%s\IndexRequest;';
    protected $httpPath; // api 请求路径的尾部, /user/login
    protected $requestTag; // swagger 文档的 tag，例如 Api.Report
    protected $requestNamespace = 'App\Http\Requests\Api\V1\%s'; // App\Http\Requests\Api\V1\User\Login
    protected $controllerClassName; // LoginController
    protected $controllerFilePath = 'app/Http/Controllers/Api/V1/%sController.php'; // app/Http/Controllers/Api/V1/User/LoginController.php
    protected $requestFilePath = 'app/Http/Requests/Api/V1/%s/IndexRequest.php'; // app/Http/Requests/Api/V1/User/Login/IndexRequest.php

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->intArguments();
        $this->generate();
        return 0;
    }

    protected function generate()
    {
        $this->generateController();
        $this->generateRequest();
        $this->info('generate files success' . PHP_EOL);
        $this->info($this->controllerFilePath . PHP_EOL);
        $this->info($this->requestNamespace . PHP_EOL);
    }

    protected function generateRequest()
    {
        $template = str_replace([
            '{{namespace}}',
        ], [
            $this->requestNamespace,
        ], $this->getRequestStub());

        $this->generateFile(base_path($this->requestFilePath), $template);
    }

    protected function generateController()
    {
        $template = str_replace([
            '{{namespace}}',
            '{{requestUse}}',
            '{{controllerClassName}}',
            '{{httpPath}}',
            '{{tag}}',
        ], [
            $this->controllerNamespace,
            $this->requestUse,
            $this->controllerClassName,
            $this->httpPath,
            $this->requestTag,
        ], $this->getControllerStub());

        $this->generateFile(base_path($this->controllerFilePath), $template);
    }

    protected function generateFile($filePath, $content)
    {
        $dirPath = dirname($filePath);
        if (!is_dir($dirPath)) {
            mkdir($dirPath, 0777, true);
        }

        file_put_contents($filePath, $content);
    }

    protected function intArguments()
    {
        $this->initNamespaces();
        $this->footerPath = $this->argument('path'); // Test/TestApi
        $separatedPath = explode('/', $this->argument('path'));
        $this->requestTag = 'Api.' . $separatedPath[0]; // Api.Test
        $underlineFooterPath = $this->underline($this->footerPath); // test/test-api
        $this->httpPath = '/' . $underlineFooterPath; // /test/api-test
        $this->controllerFilePath = sprintf($this->controllerFilePath, $this->footerPath);
        $this->requestFilePath = sprintf($this->requestFilePath, $this->footerPath);
    }

    protected function initNamespaces()
    {
        $separatedPath = explode('/', $this->argument('path'));
        $requestNamespaceFooter = implode('\\', $separatedPath); //  User\Test\ApiTest
        $this->requestNamespace = sprintf($this->requestNamespace, $requestNamespaceFooter); // App\Http\Requests\Api\V1\User\Test\ApiTest
        $this->requestUse = sprintf($this->requestUse, $requestNamespaceFooter); // use App\Http\Requests\Api\V1\User\Test\ApiTest\IndexRequest;
        list($lastWordOfPath) = array_splice($separatedPath, -1, 1); // ApiTest
        $this->controllerClassName = $lastWordOfPath . 'Controller'; // ApiTestController

        $controllerNamespaceFooter = implode('\\', $separatedPath); // User\Test
        $this->controllerNamespace = sprintf($this->controllerNamespace, $controllerNamespaceFooter); // App\Http\Controllers\Api\V1\User\Test
    }

    /**
     * 将驼峰样式的字符串转换成下划线样式的字符串
     * @param $sting
     * @return string
     */
    protected function underline($sting): string
    {
        return strtolower(preg_replace('/(?<=[a-z])([A-Z])/', '-$1', $sting));
    }

    public function getControllerStub()
    {
        return file_get_contents(base_path('stubs/Make/Api/controller.stub'));
    }

    public function getRequestStub()
    {
        return file_get_contents(base_path('stubs/Make/Api/request.stub'));
    }
}
