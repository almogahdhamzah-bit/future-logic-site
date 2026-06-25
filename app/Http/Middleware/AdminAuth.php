<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // 🔐 بيانات الدخول الخاصة بك
        $adminUser = 'hamza';
        $adminPass = '123456'; 

        if ($request->getUser() != $adminUser || $request->getPassword() != $adminPass) {
            $headers = ['WWW-Authenticate' => 'Basic realm="Admin Area"'];
            return response('غير مصرح لك بدخول لوحة التحكم!', 401, $headers);
        }

        return $next($request);
    }
}