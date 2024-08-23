<?php

namespace App\Http\Controllers;

use App\Http\Requests\saveDepartementRequest;
use App\Models\Departement;
use Illuminate\Http\Request;
use Exception;

class DepartementController extends Controller
{
    public function index(){
        $departements = Departement::paginate(10);
        return view("departements.index", compact("departements"));
    }
    
    public function create(){
        return view("departements.create");
    }
    
    public function edit(Departement $departement)
    {
        return view("departements.edit", compact("departement"));
    }

    //action d'interraction avec la BD
    public function store(Departement $departement, saveDepartementRequest $request){

        //Enregistrer un nouveau departement
        try{ 
            $departement->name = $request->name;
            $departement->save();
            return redirect()->route("departements.index")->with("success_message","Département enregestré");
        }
        catch(Exception $e){
            dd($e);
        }
    }

    public function update(Departement $departement, saveDepartementRequest $request){

        //Mettre a jour un departement
        try{ 
            $departement->name = $request->name;
            $departement->update();
            return redirect()->route("departements.index")->with("success_message","Département mise a jour");
        }
        catch(Exception $e){
            dd($e);
        }
    }

    public function delete(Departement $departement){

        //Supprimer un departement
        try{ 

            $employersCount = $departement->employers()->count();
            if ($employersCount > 0) {
                // Rediriger avec un message d'erreur si des employés sont associés
                return redirect()->route("departements.index")->with("error_message", "Impossible de supprimer ce département car il y a $employersCount employé(s) qui y sont associé(s).");
            }
    
            // Supprimer le département si aucun employé n'est associé
            $departement->delete();
    
            return redirect()->route("departements.index")->with("success_message", "Département supprimé avec succès.");
        
           // $departement->delete();
           // return redirect()->route("departements.index")->with("success_message","Département supprimé");
        }
        catch(Exception $e){
            dd($e);
        }
    }

}
