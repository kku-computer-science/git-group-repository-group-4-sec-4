<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TrackUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
}namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class TrackUserActivity
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user(); // รับข้อมูลผู้ใช้ที่ล็อกอินอยู่
        $route = $request->route()->getName(); // รับชื่อ route ปัจจุบัน
        $action = $request->method(); // รับประเภทของ HTTP request (GET, POST, etc.)

        // บันทึกข้อมูลใน log
        if ($user) {
            Log::info("User {$user->id} is accessing {$route} with action {$action}");
        } else {
            Log::info("Guest is accessing {$route} with action {$action}");
        }

        return $next($request);
    }
}

