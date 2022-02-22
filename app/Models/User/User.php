<?php

namespace App\Models\User;

use App\Models\Material\Material;
use App\Models\Material\SubscribeMaterial;
use App\Models\Model;
use App\Models\Pay\Order;
use App\Services\User\Money\TodayIncomeCache;
use App\Services\User\PersonPageQrcode;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use HasFactory;

    protected $table = 'u_user';

    protected $fillable = ['nickname', 'avatar', 'qrcode_path', 'balance', 'id_card', 'real_name', 'alipay_account',
        'personal_signature', 'member_level', 'total_income', 'today_income', 'qrcode_url',
        'selected_material_poster_path', 'selected_material_poster_url',];

    protected $visible = ['id', 'nickname', 'avatar', 'balance', 'today_income', 'total_income', 'personal_signature',
        'qrcode_url', 'member_level', 'qrcode_path', 'selected_material_poster_path', 'selected_material_poster_url'];
}
