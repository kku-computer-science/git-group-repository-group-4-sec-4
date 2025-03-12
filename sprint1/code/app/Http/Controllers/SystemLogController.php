<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SystemLogController extends Controller
{
    public function index()
    {
        return $this->getLogs();
    }

    public function logLogin()
    {
        return $this->getLogs('LOGIN');
    }

    public function logError()
    {
        return $this->getLogs('ERROR');
    }

    private function getLogs($filterType = null)
    {
        $logFile = storage_path('logs/laravel.log');

        if (!file_exists($logFile)) {
            return view('logs.index', ['logs' => [], 'logsByDate' => []]);
        }

        $logs = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $parsedLogs = [];
        $logsByDate = [];
        $uniqueLogs = []; // ใช้เก็บ log ที่ไม่ซ้ำ

        foreach ($logs as $log) {
            // ตรวจสอบรูปแบบ Log ด้วย Regex
            if (preg_match('/[(.?)] (local..?): (.*)/', $log, $matches)) {
                try {
                    $dateTime = Carbon::createFromFormat('Y-m-d H:i:s', $matches[1]);
                } catch (\Exception $e) {
                    continue; // ถ้าติดปัญหา DateTime ข้ามไป
                }

                $date = $dateTime->format('Y-m-d');
                $time = $dateTime->format('H:i:s');
                $type = strtoupper($matches[2]); // เช่น LOCAL.INFO, LOCAL.ERROR
                $description = $matches[3];

                // 🔹 กรองเฉพาะประเภทที่ต้องการ
                if ($filterType) {
                    if (($filterType === 'LOGIN' && strpos($description, 'User Login') === false) ||
                        ($filterType === 'ERROR' && strpos($type, 'ERROR') === false)) {
                        continue;
                    }
                }

                // 🔹 ตรวจสอบไม่ให้ Log ซ้ำกัน
                $logKey = "$date-$time-$description"; // ใช้ date+time+description เป็น key ป้องกันซ้ำ

                if (!isset($uniqueLogs[$logKey])) {
                    $uniqueLogs[$logKey] = true; // บันทึก key นี้เพื่อป้องกันซ้ำ

                    $parsedLogs[] = [
                        'date' => $date,
                        'time' => $time,
                        'user' => Auth::user()->name ?? 'Guest', // ใช้ชื่อผู้ใช้ปัจจุบัน
                        'event' => strpos($description, 'User Login') !== false ? 'User Login' : 'Laravel Log',
                        'type' => $type,
                        'description' => $description,
                    ];

                    if (!isset($logsByDate[$date])) {
                        $logsByDate[$date] = 0;
                    }
                    $logsByDate[$date]++;
                }
            }
        }

        // 🔹 จัดรูปแบบข้อมูลให้ใช้กับ Chart.js
        $logsByDateFormatted = [];
        foreach ($logsByDate as $date => $count) {
            $logsByDateFormatted[] = ['date' => $date, 'count' => $count];
        }

        return view('logs.index', [
            'logs' => $parsedLogs,
            'logsByDate' => $logsByDateFormatted
        ]);
    }
}