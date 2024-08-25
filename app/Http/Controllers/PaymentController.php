<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\Employer;
use App\Models\Payment;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\PDF;


class PaymentController extends Controller
{
    public function index()
    {
        $defaultPaymentDateQuery= Configuration::where('type','PAYMENT_DATE')->first();
        $defaultPaymentDate = $defaultPaymentDateQuery->value;
        $convertPaymentDate = intval($defaultPaymentDate);

        $today = date('d');

        $isPaymentDay = false;

        if($convertPaymentDate == $today) {

            $isPaymentDay = true;

        }

        $payments = Payment::latest()->orderBy('id','desc')->paginate(10);
        return view("paiments.index", compact("payments" ,"isPaymentDay"));
    }

    public function effectuerPaiments()
    {

        //Verifier que nous somme a la date de paiement avant d'executer le code ci dessous

        //Table de mappage des mois anglais vers les mois en francais
        $monthMapping = [
            'JANURY'=>'JANVIER',
            'FEBRUARY'=>'FEVRIER',
            'MARCH'=>'MARS',
            'APRIL'=>'AVRIL',
            'MAY'=>'MAI',
            'JUNE'=>'JUIN',
            'JULY'=>'JUILLET',
            'AUGUST'=>'AOUT',
            'SEPTEMBER'=>'SEPTEMBRE',
            'OCTOBER'=>'OCTOBRE',
            'NOVEMBER'=>'NOVEMBRE',
            'DECEMBER'=>'DECEMBRE'
        ];

        $currentMonth = strtoupper(Carbon::now()->isoFormat('MMMM'));
        
        //Mois en cour en francais
        $currentMonthInFrench = $monthMapping[$currentMonth] ?? '';

        //Année en cour
        $currentYear = Carbon::now()->format('Y');

        //Simuler des paiements pour tous les employers dans le mois en cour
        //Les paiements concerne les employers qui n'ont pas ecore été payé dans le mois actuel

        $employers = Employer::whereDoesntHave('payments', function ($query) use( $currentYear, $currentMonthInFrench) {
            $query->where('month', '=', $currentMonthInFrench)->where('year', '=', $currentYear);
        })->get();

        if($employers->count()== 0) {
            
            return redirect()->back()->with('error_message','Tous vos employer ont été payés pour ce mois ' . $currentMonthInFrench);
        }

        //Faire les paiement pour ces employers
        foreach($employers as $employer){
            
            $aEtePayer = $employer->payments()->where('month', '=' , $currentMonthInFrench)->where('year','=', $currentYear)->exists();

            if(!$aEtePayer){
                $salaire = $employer->montan_journalier * 30;

                $payment = new Payment([
                    'reference' => strtoupper(Str::random(10)),
                    'employer_id' => $employer->id,
                    'amount' => $salaire,
                    'launch_date' => now(),
                    'done_time' => now(),
                    'status'=> 'SUCCESS',
                    'month' => $currentMonthInFrench,
                    'year' => $currentYear
                ]);

                $payment->save();
            }
        }

        return redirect()->back()->with('success_message','Paiement des employers effectuer pour le mois de '. $currentMonthInFrench);

    }

    public function download_invoice(Payment $payment){

        try {
            
            $fullPaymentInfo = Payment::with('employer')->find($payment->id);

            //Generer le PDF

            //return view('paiments.facture' , compact('fullPaymentInfo'));

            $pdf = app(PDF::class); // Résout le service PDF à partir du conteneur

            $pdf->loadView('paiments.facture', compact('fullPaymentInfo')); // Charge une vue pour générer le PDF

            return $pdf->download('facture_'. $fullPaymentInfo->employer->nom.'.pdf' );

        } catch (Exception $e) {
            throw new Exception("Une erreur est servenue lors du téléchargement de la facture");
        }
    }
}
