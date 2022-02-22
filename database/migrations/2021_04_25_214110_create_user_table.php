<?php

use App\Models\User\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(User::table(), function (Blueprint $table) {
            $table->id();
            $table->string('nickname', 50)->default('昵称')->comment('昵称');
            $table->string('avatar')->default('')->comment('头像url');
            $table->string('qrcode_path')->default('')->comment('个人主页二维码的路径');
            $table->string('selected_material_poster_path')->default('')->comment('精选料包海报图的路径');
            $table->unsignedDecimal('balance')->default(0.00)->comment('余额');
            $table->unsignedDecimal('total_income')->default(0.00)->comment('出售物料获得的累计收益');
            $table->string('id_card', 20)->default('')->comment('身份证号码');
            $table->string('real_name', 8)->default('')->comment('真实姓名');
            $table->string('alipay_account', 30)->default('')->comment('支付宝账号');
            $table->string('personal_signature', 100)->default('')->comment('个性签名');
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('created_at')->useCurrent();
        });

        setTableComment(User::class, '用户表');


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(User::table());
    }
}
