<?php

use Illuminate\Http\Response;

if (!function_exists('success')) {
    /**
     * 成功响应
     *
     * @return \Illuminate\Http\JsonResponse
     */
    function success(): \Illuminate\Http\JsonResponse
    {
        return response()->json(null, Response::HTTP_OK);
    }
}

if (!function_exists('created')) {
    /**
     * 创建成功的响应
     *
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    function created($data): \Illuminate\Http\JsonResponse
    {
        return response()->json($data, Response::HTTP_CREATED);
    }
}

if (!function_exists('updated')) {
    /**
     * 更新成功后的响应
     *
     * @return \Illuminate\Http\JsonResponse
     */
    function updated(): \Illuminate\Http\JsonResponse
    {
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}

if (!function_exists('error')) {
    /**
     * 失败响应
     *
     * @param string $error
     * @param null $code
     * @return \Illuminate\Http\JsonResponse
     */
    function error($error = '操作失败', $code = null): \Illuminate\Http\JsonResponse
    {
        return response()->json(['error' => $error], $code ?: Response::HTTP_BAD_REQUEST);
    }
}

if (!function_exists('notFound')) {
    /**
     * 403响应
     *
     * @param string $error
     * @return \Illuminate\Http\JsonResponse
     */
    function forbidden($error = '没有权限进行此操作'): \Illuminate\Http\JsonResponse
    {
        return error($error, Response::HTTP_FORBIDDEN);
    }
}

if (!function_exists('notFound')) {
    /**
     * 404响应
     *
     * @param string $error
     * @return \Illuminate\Http\JsonResponse
     */
    function notFound($error = '未找到数据'): \Illuminate\Http\JsonResponse
    {
        return error($error, Response::HTTP_NOT_FOUND);
    }
}

if (!function_exists('apiSuccess')) {
    /**
     * @param array $data
     * @param string $msg
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    function apiSuccess($data = [], $msg = '成功', $headers = []): \Illuminate\Http\JsonResponse
    {
        return apiResponse($msg, 0, $data, $headers);
    }
}

if (!function_exists('apiError')) {
    /**
     * @param string $msg
     * @param int $code
     * @param array $data
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    function apiError($msg = '失败', $code = -1, $data = [], $headers = []): \Illuminate\Http\JsonResponse
    {
        return apiResponse($msg, $code, $data, $headers);
    }
}

if (!function_exists('apiResponse')) {
    /**
     * @param string $msg
     * @param int $code
     * @param array $data
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    function apiResponse($msg, $code, $data, $headers): \Illuminate\Http\JsonResponse
    {
        $response = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
        ];

        return response()
            ->json($response)
            ->withHeaders($headers)
            ->withCallback(request('callback'));
    }
}
