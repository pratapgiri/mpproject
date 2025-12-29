<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;

use Closure;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserActiveMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $guard = Auth::getDefaultDriver();
        if ($request->is('api/*')) {
            $userId = JWTAuth::toUser(JWTAuth::getToken())->id;

            if ($userId) {
                $profile = User::find($userId);
                if ($profile) {
                    if ($profile->status == 0) {
                        $response['status'] = false;
                        $response['data'] = (object)[];
                        $response['message'] =  Config::get('message-constants.Account_deactivated');



                        // JWTAuth::invalidate(JWTAuth::getToken());
                        // UserDevice::where(['user_id'=>$userId])->delete();
                        return response()->json($response, 201);
                    }
                } else {
                    $response['status'] = false;
                    $response['data'] = (object)[];
                    $response['message'] = Config::get('message-constants.User_not_exist');

                    // JWTAuth::invalidate(JWTAuth::getToken());
                    // UserDevice::where(['user_id'=>$userId])->delete();
                    return response()->json($response, 201);
                }
            }
        } else {

            if (Auth::guard($guard)->check() && Auth::guard($guard)->User()->status == 0 && in_array($guard, ['web'])) {
                Auth::guard($guard)->Logout();
                $request->session()->flash('alert-danger',  Config::get('message-constants.Account_deactivated'));
                return redirect()->route('login');
            }
        }

        return $next($request);
    }
}
