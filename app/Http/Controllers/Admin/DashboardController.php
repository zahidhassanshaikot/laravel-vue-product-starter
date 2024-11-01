<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RoleService;
use App\Services\UserService;
use Carbon\Carbon;

class DashboardController extends Controller
{
    protected $userService;
    protected $RoleService;

    public function __construct(
        UserService $userService,
        RoleService $RoleService,
    ){
        $this->userService      = $userService;
        $this->RoleService      = $RoleService;
    }

    public function index()
    {
        setPageMeta('Dashboard');

        $users                  = $this->userService->get();
        $total_role             = $this->RoleService->get()->count();

        $user_this_month        = $users->filter(function ($q) {
            if($q->created_at != null){
                return $q->created_at->month == now()->month;
            }
        })->count();
        $user_last_six_month    = $users->filter(function ($q) {
            if($q->created_at != null){
                return $q->created_at->month >= now()->subMonth(6)->month;
            }
        })->count();
        $user_this_year         = $users->filter(function ($q) {
            if($q->created_at != null){
                return $q->created_at->year == now()->year;
            }
        })->count();

        $user_monthly_data      = $users->groupBy(function($date) {
            //return Carbon::parse($date->created_at)->format('Y'); // grouping by years
            if($date->created_at != null) {
                return Carbon::parse($date->created_at)->format('m'); // grouping by months
            }
        });
        $usermcount             = [];
        $userArr                = [];

        foreach ($user_monthly_data as $key => $value) {
            $usermcount[(int)$key] = count($value);
        }

        for($i = 1; $i <= 12; $i++){
            if(!empty($usermcount[$i])){
                $userArr[] = $usermcount[$i];
            }else{
                $userArr[] = 0;
            }
        }

        $data = [
            'total_user'                => $users->count(),
            'total_role'                => $total_role,
            'user_this_month'           => $user_this_month,
            'user_last_six_month'       => $user_last_six_month,
            'user_this_year'            => $user_this_year,
            'user_monthly_analytics'    => $userArr,
        ];
        return view('admin.dashboard', $data);
    }
}
