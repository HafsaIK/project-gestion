<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\Request;
use App\Models\Departement;
use App\Models\Employer;
use App\Models\User;
use Carbon\Carbon;
use PHPUnit\Framework\Constraint\Count;

class AppController extends Controller
{
    public function index(){
        $totalDepartements = Departement::all()->count();
        $totalEmployers = Employer::all()->count();
        $totalAdministrateurs = User::all()->count();
        

        //$appName= Configuration::where('type','APP_NAME')->first();

        $defaultPaymentDateQuery = null;
        $paymentNotification = "";

        $currentDate = Carbon::now()->day;

        $defaultPaymentDateQuery= Configuration::where('type','PAYMENT_DATE')->first();
        
        if ($defaultPaymentDateQuery) {
            $defaultPaymentDate = $defaultPaymentDateQuery->value;
            $convertPaymentDate = intval($defaultPaymentDate);

            if ($currentDate === $convertPaymentDate) {

                $paymentNotification = "Le paiement doit avoir lieu aujourd'hui, le " . $defaultPaymentDate . " de ce mois";
            
            } elseif ($currentDate < $convertPaymentDate) {
            
                $paymentNotification = "Le paiement doit avoir lieu le " . $defaultPaymentDate . " de ce mois";
            
            } else {
            
                $nextMonth = Carbon::now()->addMonth();
                $nextMonthName = $nextMonth->format('F');
                
                $paymentNotification = "Le paiement doit avoir lieu le " . $defaultPaymentDate . " du mois de " . $nextMonthName;
            
            }
        }
        

        return view('auth.dashboard',compact('totalDepartements','totalEmployers','totalAdministrateurs','paymentNotification'));
    }
}
