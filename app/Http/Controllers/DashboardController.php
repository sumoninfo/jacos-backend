<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Prescription;
use App\Models\Serial;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
  /**
   * Get Dashboard data
   *
   * @param Request $request
   */
  public function getDashboardData(Request $request)
  {
    $data = [];
    //users
    $user                        = User::with('hospital')->getOursDoctorsPatients();
    $data['total_doctors']       = with(clone $user)->getDoctors()->count();
    $data['total_patients']      = with(clone $user)->getPatients()->count();
    $data['total_appointments']  = Appointment::getDoctorsPatients()->count();
    $data['total_prescriptions'] = Prescription::getDoctorsPatients()->count();
    $data['total_serials']       = Serial::getSerials()->count();
    $data['total_invoices']      = Transaction::getInvoices()->count();
    return $data;
  }
}
