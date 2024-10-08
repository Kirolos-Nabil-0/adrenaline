<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IpMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $currentUser = Auth::user();
        if ($currentUser) {
            if ($currentUser->role == 'admin'||$currentUser->role == 'instructor') {
                return $next($request);
            } else {
//                $ip = $_SERVER['REMOTE_ADDR'];
                if (isset($_COOKIE['browser_token'])) {
                    $browser_token = $_COOKIE['browser_token'];
                } else {
                    $browser_token = '[]';
                }
                $browser_token = json_decode($browser_token);
                if (count($browser_token) == 0) {
                    Auth::logout();
                    return redirect()->route('login');
                } else {

                    $exist=-1;
                    for ($i=0;$i<count($browser_token);$i++){
                        if($browser_token[$i]->id==$currentUser->id){
                            $exist=$i;
                        }
                    }
                    $selectedToken = $exist==-1?null:$browser_token[$exist];
                    if ($exist!=-1&&$currentUser->browser_token == $selectedToken->token) {
                        return $next($request);
                    } else {
                        Auth::logout();
                        return redirect()->route('login');
                    }
                }
            }
        } else {
            return redirect()->route('login');
        }
    }
}
