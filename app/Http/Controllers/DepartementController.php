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
            $departement->delete();
            return redirect()->route("departements.index")->with("success_message","Département supprimé");
        }
        catch(Exception $e){
            dd($e);
        }
    }

}
