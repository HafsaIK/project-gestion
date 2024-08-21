<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\Request;
use App\Models\Departement;
use App\Models\Employer;
use App\Models\User;
use PHPUnit\Framework\Constraint\Count;

class AppController extends Controller
{
    public function index(){
        $totalDepartements = Departement::all()->count();
        $totalEmployers = Employer::all()->count();
        $totalAdministrateurs = User::all()->count();
        

        $appName= Configuration::where('type','APP_NAME')->first();

        

        return view('auth.dashboard',compact('totalDepartements','totalEmployers','totalAdministrateurs'));
    }
}
