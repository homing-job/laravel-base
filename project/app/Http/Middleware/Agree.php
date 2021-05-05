<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

// 同意してるかチェックするミドルウェア
class Agree
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!$request->agree) {
            // 同意してなかったら同意画面へリダイレクト
            return redirect()->route('agree');
        }
        return $next($request);
    }
}
