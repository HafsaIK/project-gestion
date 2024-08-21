<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeConfigRequest;
use App\Models\Configuration;
use Exception;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    public function index()
    {
        $allConfiguration = Configuration::latest()->paginate(10);
        return view("config/index", compact("allConfiguration"));
    }

    public function create()
    {
        return view("config.create");
    }

    public function store(storeConfigRequest $request){
         try {
            Configuration::create($request->all());
            return redirect()->route("configurations")->with("success_message","Configuration ajouté");
         } catch (Exception $e) {
            dd($e);
            throw new Exception("Error lors de l'enregistrement de la configuration");
            
         }
    }

    public function delete(Configuration $configuration)
    {
        try {
            $configuration->delete();
            return redirect()->route("configurations")->with("success_message","Configuration retiré");
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la suppression de la configuration  ");
        }
    }
}
