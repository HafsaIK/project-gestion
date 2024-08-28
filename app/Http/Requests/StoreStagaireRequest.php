<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStagaireRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'departement_id' => 'required|integer',
            'nom'=> 'required|string',
            'prenom'=> 'required|string',
            'email'=> 'required|unique:stagaires,email',
            'contact'=> 'required|unique:stagaires,contact',
            'duree_stage'=> 'required'
        ];
    }

    public function messages(){
        return [
            'email.required'=> 'Le mail est requis',
            'email.unique'=> 'Le mail est déja pris',
            'contact.required'=> 'Le numero de teléphone est requis',
            'contact.unique'=> 'Le numero de teléphone est déja pris',
            'nom.required' => 'Le nom est requis',
            'prenom.required' => 'Le prenom est requis',
            'duree_stage.required' => 'La durée du stage est requis'
        ];

    }
}
