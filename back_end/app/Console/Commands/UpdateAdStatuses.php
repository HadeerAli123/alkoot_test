<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ads; 
use Carbon\Carbon;

class UpdateAdStatuses extends Command
{
    protected $signature = 'ads:update-status';
    protected $description = 'تحديث حالة الإعلانات تلقائياً حسب التاريخ';

    public function handle()
    {
        $now = Carbon::now();

        // الحملات اللي المفروض تبدأ دلوقتي
        Ads::where('status', 'pending')
            ->where('start_date', '<=', $now)
            ->update(['status' => 'active']);

        // الحملات اللي انتهت
        Ads::where('status', 'active')
            ->where('end_date', '<', $now)
            ->update(['status' => 'inactive']);

        $this->info(' تم تحديث حالات الإعلانات بنجاح.');
    }
}
