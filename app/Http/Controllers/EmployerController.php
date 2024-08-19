<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Models\Employer;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEmployeRequest;


class EmployerController extends Controller
{
    public function index(){
        $employers = Employer::paginate(10);
        return view("employers.index", compact("employers"));
    }
    
    public function create(){
        $departements = Departement::all();
        return view("employers.create", compact("departements"));
    }
    
    public function edit(Employer $employer){
        return view("employers.edit", compact("employer
        "));
    }

    public function store(StoreEmployeRequest $request){

        $query = Employer::create($request->all());

        if( $query){
            return redirect()->route("employers.index")->with("success_message","Employer ajouté");
        }

    }
}
