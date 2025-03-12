<?php
namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogHelper
{
    public static function log($date, $user, $activity, $status)
    {
        try {
            // สร้าง log entry ในฐานข้อมูล
            ActivityLog::create([
                'date_time' => $date,
                'user' => $user, // หรือใช้ Auth::user()->id หากต้องการข้อมูลเพิ่มเติม
                'activity' => $activity,
                'status' => $status,
            ]);

            // บันทึกข้อมูลใน log file ของ Laravel
            Log::info('Log entry created for user ID: ' . Auth::id());
        } catch (\Exception $e) {
            // หากเกิดข้อผิดพลาดในการสร้าง log
            Log::error("Failed to insert log: " . $e->getMessage());
        }
    }
}
