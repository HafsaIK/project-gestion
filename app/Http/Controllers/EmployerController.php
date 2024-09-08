<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Models\Employer;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEmployeRequest;
use App\Http\Requests\submitDefineAccessEmployerRequest;
use App\Http\Requests\UpdateEmployerRequest;
use App\Models\ResetCodePasswordEmployer;
use App\Notifications\SendEmailToEmployerAfterRegistrationNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

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
        //    $query = Employer::create($request->all());

        //    if( $query){
        //        return redirect()->route("employers.index")->with("success_message","Employer ajouté");
        //    }

            $employer = new Employer($request->all()); // Remplir tous les champs
            $employer->password = Hash::make('default'); // Définir le mot de passe par défaut
            $employer->save(); // Enregistrer l'employé dans la base de données

            //Envoyer un code par email pour vérification

            if($employer){

                try {
                    ResetCodePasswordEmployer::where('email', $employer->email)->delete();
                    $code = rand(1000,4000);

                    $data = [
                        'code' => $code,
                        'email' => $employer->email
                    ];

                    ResetCodePasswordEmployer::create($data);

                    Notification::route('mail', $employer->email)->notify(new SendEmailToEmployerAfterRegistrationNotification($code, $employer->email));

                    //Rediriger l'utilisateur vers un URL

                    return redirect()->route('employers.index')->with('success_message','employeur ajouté');
                } catch (Exception $e) {
                    dd($e); 
                    throw new Exception("Une erreur est servenue lors de l'envoie du mail");
                }
            }


        } catch (Exception $e) {
            //dd($e);
            throw new Exception('Une erreur est survenue lors de la création de cet employeur') ;
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
            //dd($e);
            throw new Exception('Une erreur est survenue lors de la mise a jour de cet employeur') ;
            }
    }

    public function delete(Employer $employer){
        try {
    
            $employer->delete();

            return redirect()->route("employers.index")->with("success_message","Employer retirer");

        } catch (Exception $e) {
            //dd($e);
            throw new Exception('Une erreur est survenue lors de la suppression de cet employeur') ;

            }
    }

    public function defineAccessEmp($email)
    {

        $checkUserExist = Employer::where("email", $email)->first();
        
        if($checkUserExist){

            return view('auth.validate-account-emp', compact('email'));


        }else{
            
            //rediriger sur une route 404
            //return redirect()->route("login");
        }
    }

    public function SubmitDefineAccessEmp(submitDefineAccessEmployerRequest $request)
    {
        try {
            $employer = Employer::where('email', $request->email)->first();

            if($employer){
                $employer->password = Hash::make($request->password);
                $employer->email_verified_at = Carbon::now();
                $employer->update();

                //Si la mise a jour fait correctement
                if($employer){
                    $existingCode =  ResetCodePasswordEmployer::where('email', $employer->email)->count();
                }

                if($existingCode >= 1){
                    ResetCodePasswordEmployer::where('email', $employer->email)->delete();
                }
                return redirect()->route('loginEmp')->with('success_message','Vos acces correctement défini');
            }else{
            //rediriger sur une route 404
        }
            
        } catch (Exception $e) {
            dd($e);
        }
    }
}


