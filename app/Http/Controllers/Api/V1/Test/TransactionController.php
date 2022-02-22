<?php

namespace App\Http\Controllers\Api\V1\Test;

use App\Exceptions\Api\ApiException;
use App\Http\Controllers\Api\V1\BaseController;
use App\Http\Requests\Api\V1\Test\Transaction\IndexRequest;
use App\Models\Material\Material;
use Illuminate\Support\Facades\DB;

class TransactionController extends BaseController
{
    /**
     * @OA\Post(
     *     path="/test/transaction",
     *     tags={"Api.Test"},
     *     summary="summary",
     *     description="description",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(
     *                  ref="#/components/schemas/LoginedApiBody",
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="success",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="code",
     *                  ref="#/components/schemas/code",
     *              ),
     *              @OA\Property(
     *                  property="msg",
     *                  ref="#/components/schemas/msg",
     *              ),
     *          ),
     *     ),
     * )
     * @param IndexRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function index()
    {
        $result = DB::transaction(function() {
            Material::whereId(1)->update(['title' => 'transaction  1']);

            throw new ApiException('transaction');
            Material::whereId(2)->update(['title' => 'transaction  2']);
            return true;
        });

        $response = [
            'result' => $result,
        ];
        return apiSuccess();
    }
}
