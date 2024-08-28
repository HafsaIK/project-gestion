<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStagaireRequest;
use App\Http\Requests\UpdateStagaireRequest;
use App\Models\Departement;
use App\Models\Stagaire;
use Exception;
use Illuminate\Http\Request;

class StagaireController extends Controller
{
    public function index(){
        $stagaires = Stagaire::with('departement')->paginate(10);
        return view("stagaires.index", compact("stagaires"));
    }

    public function create(){
        $departements = Departement::all();
        return view("stagaires.create", compact("departements"));
    }

    public function edit(Stagaire $stagaire)
    {
        $departements = Departement::all();
        return view("stagaires.edit", compact("stagaire", 'departements'));
    }

    public function store(StoreStagaireRequest $request){

        try {
            $query = Stagaire::create($request->all());

            if( $query){
                return redirect()->route("stagaires.index")->with("success_message","Stagaire ajouté");
            }
        } catch (Exception $e) {
            dd($e);
            }
    }

    public function update(UpdateStagaireRequest $request ,Stagaire $stagaire){
        try {
            // Récupérer les données validées de la requête
            $data = $request->validated();
        
            // Mettre à jour l'employer avec les nouvelles données
            $stagaire->update($data);

            return redirect()->route("stagaires.index")->with("success_message","Les information du stagaire ont été mise a jour");

        } catch (Exception $e) {
            dd($e);
            }
    }

    public function delete(Stagaire $stagaire){
        try {
    
            $stagaire->delete();

            return redirect()->route("stagaires.index")->with("success_message","Stagaire retirer");

        } catch (Exception $e) {
            dd($e);
            }
    }
}
