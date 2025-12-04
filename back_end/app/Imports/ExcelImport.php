<?php

namespace App\Imports;

use App\Models\Excel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ExcelImport implements ToModel, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function startRow(): int
    {
        return 2; // Skip first row (headers)
    }

    public function model(array $row)
    {
        return new Excel([
            'campaign_id'  =>(string)$row[0],
            'campaign_name'   => (string)$row[1],
            'ad_GIcode' => (string)$row[2],
            'ad_Gname'  => (string)$row[3],
            'design_id'   => (string)$row[4],
            'advertisement_code' => (string)$row[5],
            'advertisement_name'  => (string)$row[6],
            'active_status'   => (string)$row[7],
            'ad_type' => (string)$row[8],
            'amount_spent'  => (string)$row[9],
            'result'   => (string)$row[10],
            'result_type' => (string)$row[11],
            'cost_result'  => (string)$row[12],
            'cost_result_type'   => (string)$row[13],
            'uploaded_impressions' => (string)$row[14],
            'eCPM' => (string)$row[15],
            'clicks' => (string)$row[16],
            'eCPC' => (string)$row[17],
            'app_install' => (string)$row[18],
            'cost_app_install' => (string)$row[19],
            'rate_app_install' => (string)$row[20],
        ]);
    }
}
