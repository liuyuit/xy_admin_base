<?php

/**
 * @OA\Schema(
 *     schema="access_token",
 *     type="string",
 *     example="78657360364647286045dbeb15ba6",
 *     description="用于验证权限的token,当 token 过期时，请求接口将会响应 code 为 -1001。此时可以请求刷新 token 接口。重新获取 token",
 * ),
 * @OA\Schema(
 *     schema="refresh_token",
 *     type="string",
 *     example="78657360364647286045dbeb15f8f",
 *     description="刷新access_token,用于获取新的access_token和refresh_token，并且刷新过期时间",
 * ),
 * @OA\Schema(
 *     schema="expires_in",
 *     type="integer",
 *     example="86400",
 *     description="access_token剩余有效时间,单位(秒)",
 * ),
 * @OA\Schema(
 *     schema="refresh_token_expires_in",
 *     type="integer",
 *     example="2592000",
 *     description="refresh_token剩余有效时间,单位(秒)",
 * ),
 *  * @OA\Schema(
 *     schema="token_body",
 *     type="object",
 *     @OA\Property(
 *          property="access_token",
 *          ref="#/components/schemas/access_token",
 *     ),
 *     @OA\Property(
 *          property="refresh_token",
 *          ref="#/components/schemas/refresh_token",
 *     ),
 *     @OA\Property(
 *          property="expires_in",
 *          ref="#/components/schemas/expires_in",
 *     ),
 *     @OA\Property(
 *          property="refresh_token_expires_in",
 *          ref="#/components/schemas/refresh_token_expires_in",
 *     ),
 * ),
 */