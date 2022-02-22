<?php

/**
 * @OA\Schema(
 *     schema="rest",
 *     type="string",
 *     description="json 字符串，客户端信息，如机型、系统、ip 等信息",
 * )
 *
 * @OA\Schema (
 *     schema="BasicReportApi",
 *     type="object",
 *     description="上报数据的 api 接口基础请求参数",
 *     @OA\Property(
 *          property="rest",
 *          ref="#/components/schemas/rest",
 *     ),
 * )
 * @OA\Schema (
 *     schema="AuthorizedApiBody",
 *     type="object",
 *     description="需要鉴权的 API 接口请求参数",
 *     @OA\Property(
 *          property="access_token",
 *          ref="#/components/schemas/access_token",
 *     ),
 *     @OA\Property(
 *          property="uid",
 *          ref="#/components/schemas/uid",
 *     ),
 * )
 * @OA\Schema (
 *     schema="ReportAuthorizedApi",
 *     type="object",
 *     description="上报数据以及鉴权的 api 接口基础请求参数",
 *     @OA\Property(
 *          property="rest",
 *          ref="#/components/schemas/rest",
 *     ),
 *     allOf={
 *          @OA\Schema(
 *              ref="#/components/schemas/AuthorizedApiBody",
 *          )
 *     },
 * )
 * @OA\Schema (
 *     schema="LoginedApiBody",
 *     type="object",
 *     description="已经登陆的 API 接口请求参数",
 *     @OA\Property(
 *          property="access_token",
 *          ref="#/components/schemas/access_token",
 *     ),
 *     @OA\Property(
 *          property="uid",
 *          ref="#/components/schemas/uid",
 *     ),
 *     @OA\Property(
 *          property="sub_uid",
 *          ref="#/components/schemas/sub_uid",
 *     ),
 * )
 * @OA\Schema (
 *     schema="ReportLoginedApi",
 *     type="object",
 *     description="上报数据并且已经登录的 api 接口基础请求参数",
 *     @OA\Property(
 *          property="rest",
 *          ref="#/components/schemas/rest",
 *     ),
 *     allOf={
 *          @OA\Schema(
 *              ref="#/components/schemas/LoginedApiBody",
 *          )
 *     },
 * )
 * @OA\Schema (
 *     schema="uid",
 *     type="integer",
 *     format="int32",
 *     example=1,
 *     description="用户ID",
 * )
 * @OA\Schema (
 *     schema="avatar",
 *     type="string",
 *     example="https://thirdwx.qlogo.cn/mmopen/vi_32/NIAuuyMibmEQ/132",
 *     description="头像url",
 * )
 * @OA\Schema (
 *     schema="balance",
 *     type="string",
 *     example="12.23",
 *     description="余额",
 * )
 * @OA\Schema (
 *     schema="personal_signature",
 *     type="string",
 *     example="我的个性签名",
 *     description="用户个性签名",
 * )
 * @OA\Parameter (
 *     name="uid",
 *     in="path",
 *     required=true,
 *     @OA\Schema(ref="#/components/schemas/uid"),
 *     description="用户ID",
 * )
 * @OA\Schema(
 *     schema="nickname",
 *     type="string",
 *     example="昵称",
 *     description="用户昵称",
 * ),
 * @OA\Schema (
 *     schema="user_body",
 *     type="object",
 *     @OA\Property(
 *          property="nickname",
 *          ref="#/components/schemas/nickname",
 *     ),
 *     @OA\Property(
 *          property="avatar",
 *          ref="#/components/schemas/avatar",
 *     ),
 *     @OA\Property(
 *          property="personal_signature",
 *          ref="#/components/schemas/personal_signature",
 *     ),
 *     @OA\Property(
 *          property="qrcode_url",
 *          ref="#/components/schemas/qrcode_url",
 *     ),
 *     @OA\Property(
 *          property="selected_material_poster_url",
 *          ref="#/components/schemas/selected_material_poster_url",
 *     ),
 * )
 * @OA\Schema (
 *     schema="user",
 *     @OA\Property(
 *         property="id",
 *         ref="#/components/schemas/uid",
 *     ),
 *     allOf={
 *         @OA\Schema(ref="#/components/schemas/user_body")
 *     }
 * )
 * @OA\Schema (
 *     schema="me",
 *     @OA\Property(
 *         property="total_income",
 *         ref="#/components/schemas/total_income",
 *     ),
 *     @OA\Property(
 *         property="today_income",
 *         ref="#/components/schemas/today_income",
 *     ),
 *     @OA\Property(
 *         property="balance",
 *         ref="#/components/schemas/balance",
 *     ),
 *     allOf={
 *         @OA\Schema(ref="#/components/schemas/user")
 *     }
 * )
 * @OA\Schema(
 *     schema="total_income",
 *     type="string",
 *     example="30.99",
 *     description="出售物料获得的累计收益",
 * )
 * @OA\Schema(
 *     schema="today_income",
 *     type="string",
 *     example="10.99",
 *     description="出售物料获得的今日收益",
 * )
 * @OA\Schema(
 *     schema="qrcode_url",
 *     type="string",
 *     example="http://api.material.local:80/storage/image/qrcode/2021/06/25/qrcode_1_60d5d40869d9b.jpg",
 *     description="个人主页二维码 url",
 * )
 * @OA\Schema(
 *     schema="selected_material_poster_url",
 *     type="string",
 *     example="http://api.material.local/storage/image/selected-material/2021/07/06/poster60e409725cf92.jpg",
 *     description="精选料包海报的 url，为空表示用户还未选择精选料包",
 * )
 * @OA\Schema (
 *   schema="username",
 *     type="string",
 *     example="UserA",
 *     description="用户名称"
 * )
 * @OA\Schema(
 *     schema="fans_type",
 *     type="string",
 *     example="unpaid",
 *     enum={"paid","unpaid"},
 *     description="粉丝类型，paid： 付过费的粉丝（星标粉丝），unpaid：没有付过费的粉丝",
 * )
 *
 * @OA\Schema (
 *     schema="subscription",
 *     @OA\Property(
 *         property="id",
 *         ref="#/components/schemas/uid",
 *     ),
 *     @OA\Property(
 *         property="fans_type",
 *         ref="#/components/schemas/fans_type",
 *     ),
 * )
 *
 * @OA\Schema (
 *     schema="subscribe_with_fans",
 *     @OA\Property(
 *         property="fans",
 *         ref="#/components/schemas/user",
 *     ),
 *     allOf={
 *         @OA\Schema(ref="#/components/schemas/subscription")
 *     }
 * )
 *
 * @OA\Schema (
 *     schema="subscribe_with_subscription",
 *     @OA\Property(
 *         property="subscribe",
 *         ref="#/components/schemas/user",
 *     ),
 *     allOf={
 *         @OA\Schema(ref="#/components/schemas/subscription")
 *     }
 * )
 * @OA\Schema (
 *   schema="money",
 *   type="string",
 *   example="2.65",
 *   description="金额，单位元，两位小数"
 * )
 * @OA\Schema (
 *   schema="author_uid",
 *   type="interge",
 *   example="1",
 *   description="作者的 uid"
 * )
 */
