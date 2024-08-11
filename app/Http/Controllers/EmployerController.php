<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use Illuminate\Http\Request;

class EmployerController extends Controller
{
    public function index(){
        return view("employers.index");
    }
    
    public function create(){
        return view("employers.create");
    }
    
    public function edit(Employer $employer){
        return view("employers.edit", compact("employer
        "));
    }
}
