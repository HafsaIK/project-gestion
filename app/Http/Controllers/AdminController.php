<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeAdminRequest;
use App\Http\Requests\updateAdminRequest;
use App\Models\ResetCodePassword;
use App\Models\User;
use App\Notifications\SendEmailAdmainAfterRegistrationNotification;
use Exception;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function create()
    {
        return view("admin/create");
    }

    public function edit(User $user)
    {
        return view("admin/edit", compact("user"));
    }

    public function store(storeAdminRequest $request)
    {
        try {
            //logique de création de compte

            $user = new User();

            $user->name = $request->name;
            $user->email = $request->email;
            $user->name = Hash::make('default');

            $user->save();

            //Envoyer un mail pour que l'utilisateur puisse confirmer son compte


            //Envoyer un code par email pour vérification

            if($user){

                try {
                    ResetCodePassword::where('email', $user->email)->delete();
                    $code = rand(1000,4000);

                    $data = [
                        'code' => $code,
                        'email' => $user->email
                    ];

                    ResetCodePassword::create($data);

                    Notification::route('mail', $user->email)->notify(new SendEmailAdmainAfterRegistrationNotification($code, $user->email));

                } catch (Exception $e) {
                    dd($e); 
                    throw new Exception("Une erreur est servenue lors de l'envoie du mail");
                }
            }


        } catch (Exception $e) {
 
            //dd($e)

            throw new Exception('Une erreur est servenue lors de la création de cet adminidtrateur');
        
        }

    }

    public function update(updateAdminRequest $request , User $user){

        try {

            //logique de mise a jour de compte

        } catch (Exception $e) {

            //dd($e)
            throw new Exception("Une erreur est servenue lors de la mise a jour des informations de l'utilisateur");
        
        }
    }

    public function delete(User $user)
    {
        try {

            //logique de suppression de compte

        } catch (Exception $e) {

            //dd($e)
            throw new Exception("Une erreur est servenue lors de la suppression des informations de l'utilisateur");
        
        }
    }
}
