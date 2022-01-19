<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Get Dashboard data
     *
     * @param Request $request
     * @return array
     */
  public function getDashboardData(Request $request)
  {
    $data = [];
    $data['users']  = User::count();
    return $data;
  }
}
