<?php

namespace App\Http\Controllers\Api\V1\Test;

use App\Http\Controllers\Api\V1\BaseController;
use App\Http\Requests\Api\V1\Test\Route\IndexRequest;

class RouteController extends BaseController
{
    public function index()
    {
        $routeUrl = app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('api.test.test');
        $response['route_url'] = $routeUrl;
        return apiSuccess($routeUrl);
    }
}
