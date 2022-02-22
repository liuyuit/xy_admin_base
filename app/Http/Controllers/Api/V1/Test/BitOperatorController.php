<?php

namespace App\Http\Controllers\Api\V1\Test;

use App\Http\Controllers\Api\V1\BaseController;
use App\Http\Requests\Api\V1\Test\BitOperator\IndexRequest;

class BitOperatorController extends BaseController
{
    /**
     * PHP 通过位运算符做权限控制
     * @link https://www.cnblogs.com/xingmeng/p/3711553.html
     * @link https://www.cnblogs.com/guliang/p/12525319.html
     * @param IndexRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(IndexRequest $request)
    {
        //   赋予权限值-->删除：8、上传：4、写入：2、只读：1
        $a = 2^3;
        define("mDELETE",1<<3);
        define("mUPLOAD",1<<2);
        define("mWRITE",1<<1);
        define("mREAD",1<<0);
        //vvvvvvvvvvvvv使用说明vvvvvvvvvvvvv
        //部门经理的权限为(假设它拥有此部门的所有权限)，| 是位或运行符，不熟悉的就查查资料
        echo mDELETE|mUPLOAD|mWRITE|mREAD ,"<br>";//   相当于是把上面的权限值加起来：8+4+2+1=15
        //   设我只有 upload 和 read 权限，则
        echo mUPLOAD|mREAD ,"<br>";//相当于是把上传、只读的权限值分别相加：4+1=5
        /*
        *赋予它多个权限就分别取得权限值相加，又比如某位员工拥有除了删除外的权限其余都拥有，那它的权限值是多少?
        *应该是：4+2+1＝7
        *明白了怎么赋值给权限吧?
        */
        //^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
        //判断某人的权限可用，设权限值在$key中
        /*
        *判断权限用&位与符，
        */
        $key = 13;//13＝8+4+1
        if($key & mDELETE) echo "有删除权限<br>"; //8
        if($key & mUPLOAD) echo "有上传权限<br>"; //4
        $a=$key & mWRITE; echo "有写权限<br>".$a; //无此权限
        if($key & mREAD) echo "有读权限<br>";      //

//        return apiSuccess();
    }
}
