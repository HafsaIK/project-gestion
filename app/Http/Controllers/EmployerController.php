<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Models\Employer;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEmployeRequest;
use App\Http\Requests\UpdateEmployerRequest;
use Exception;

class EmployerController extends Controller
{
    public function index(){
        $employers = Employer::with('departement')->paginate(10);
        return view("employers.index", compact("employers"));
    }
    
    public function create(){
        $departements = Departement::all();
        return view("employers.create", compact("departements"));
    }
    
    public function edit(Employer $employer)
    {
        $departements = Departement::all();
        return view("employers.edit", compact("employer", 'departements'));
    }

    public function store(StoreEmployeRequest $request){

        try {
            $query = Employer::create($request->all());

            if( $query){
                return redirect()->route("employers.index")->with("success_message","Employer ajouté");
            }
        } catch (Exception $e) {
            dd($e);
            }
    }

    public function update(UpdateEmployerRequest $request ,Employer $employer){
        try {
            // Récupérer les données validées de la requête
            $data = $request->validated();
        
            // Mettre à jour l'employer avec les nouvelles données
            $employer->update($data);

            return redirect()->route("employers.index")->with("success_message","Les information de l'employer ont été mise a jour");

        } catch (Exception $e) {
            dd($e);
            }
    }

    public function delete(Employer $employer){
        try {
    
            $employer->delete();

            return redirect()->route("employers.index")->with("success_message","Employer retirer");

        } catch (Exception $e) {
            dd($e);
            }
    }
}
