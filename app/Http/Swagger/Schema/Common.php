<?php

/**
 * @OA\Schema(
 *     schema="created_at",
 *     type="string",
 *     example="2021-04-21 21:22:01",
 *     description="创建时间",
 * )
 *
 * @OA\Schema(
 *     schema="updated_at",
 *     ref="#/components/schemas/updated_at",
 *     description="更新时间"
 * )
 *
 * @OA\Schema (
 *   schema="id",
 *   type="integer",
 *   format="int32",
 *   example=1,
 *   description="id"
 * )
 *
 * @OA\Schema (
 *   schema="name",
 *   type="string",
 *   example="abc",
 *   description="名称"
 * )
 *
 * @OA\Schema (
 *   schema="keyword",
 *   type="string",
 *   example="关键字",
 *   description="模糊搜索用的关键词"
 * )
 *
 * @OA\Schema (
 *     schema="gender",
 *     type="integer",
 *     format="int16",
 *     enum={0,1,2},
 *     example=0,
 *     description="性别(0-未知,1-男,2-女)"
 * )
 *
 * @OA\Schema(
 *     schema="phone",
 *     type="string",
 *     example="13600001111",
 *     description="手机号码"
 * )
 *
 * @OA\Schema(
 *     schema="maskphone",
 *     type="string",
 *     example="136****1111",
 *     description="掩码后的手机号码"
 * )
 *
 * @OA\Schema(
 *     schema="email",
 *     type="string",
 *     example="test@ggxx.com",
 *     description="邮箱地址"
 * )
 *
 * @OA\Schema(
 *     schema="ip",
 *     type="string",
 *     example="192.168.1.101",
 *     description="IP地址"
 * )
 *
 * @OA\Schema(
 *     schema="page",
 *     type="integer",
 *     example="1",
 *     description="第几页，从 1 开始"
 * )
 *
 * @OA\Schema(
 *     schema="per_page",
 *     type="integer",
 *     example="10",
 *     description="每页几条数据，范围在 1 - 50 之间"
 * )
 *
 * @OA\Schema(
 *     schema="code",
 *     type="integer",
 *     example="0",
 *     description="状态码，0 表示成功，其他表示失败，此时需要将 msg 中的信息通过弹窗展示给用户",
 * )
 *
 * @OA\Schema(
 *     schema="msg",
 *     type="string",
 *     example="成功",
 *     description="提示信息",
 * )
 *
 * @OA\Schema(
 *     schema="redirect_client_url",
 *     type="string",
 *     example="https://api.material.liuyublog.com/storage/mp/#/pages/preview/index?id=8",
 *     description="授权成功后要跳转的前端页面地址，如果用 get 方式传参，需要将此参数 urlendoe。例如
 *  http://api.material.liuyublog.com/storage/mp/%23/pages/preview/index?id=8",
 * )
 *
 * @OA\Schema(
 *     schema="data",
 *     type="array",
 *     description="响应数据，对象或者数组",
 *     @OA\Items(
 *          @OA\Schema(
 *              type="object",
 *              @OA\Property(
 *                   property="uid",
 *                   ref="#/components/schemas/uid",
 *              ),
 *              @OA\Property(
 *                   property="name",
 *                   ref="#/components/schemas/name",
 *              ),
 *
 *          )
 *     )
 * )
 *
 *
 */
