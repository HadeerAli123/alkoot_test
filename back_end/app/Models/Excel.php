<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Excel extends Model
{
    use HasFactory;
    protected $fillable = [
        'campaign_id',
        'campaign_name',
        'ad_GIcode',
        'ad_Gname',
        'design_id',
        'advertisement_code',
        'advertisement_name',
        'active_status',
        'ad_type',
        'amount_spent',
        'result',
        'result_type',
        'cost_result',
        'cost_result_type',
        'uploaded_impressions',
        'eCPM',
        'clicks',
        'eCPC',
        'app_install',
        'cost_app_install',
        'rate_app_install', 
    ];
    protected $table = 'excels';
}
