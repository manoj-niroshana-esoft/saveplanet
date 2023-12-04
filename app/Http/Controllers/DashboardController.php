<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(){
        $this->middleware('guest');
    }
    // Dashboard - Analytics
    public function dashboardAnalytics(){
        $pageConfigs = [
            'pageHeader' => false
        ];

        return view('/pages/dashboard-analytics', [
            'pageConfigs' => $pageConfigs
        ]);
    }

    // Dashboard - Ecommerce
    public function dashboardEcommerce(){
        $pageConfigs = [
            'pageHeader' => false
        ];

        return view('/pages/dashboard-ecommerce', [
            'pageConfigs' => $pageConfigs
        ]);
    }
}

