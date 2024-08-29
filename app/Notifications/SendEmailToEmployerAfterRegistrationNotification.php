<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendEmailToEmployerAfterRegistrationNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

     public $email;
     public $code;
    
     public function __construct($codeToSend,$emailToSend)
     {
         $this->email = $emailToSend;
         $this->code = $codeToSend;
     }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage) 
                    ->subject('Création de compte employeur')
                    ->line('Bonjour')
                    ->line('Votre compte a été crée avec succés sur la platforme de gestion de salaire et d\'employer')
                    ->line('Cliquer sur le bouton ci dessous pour valider votre compte')
                    ->line('Saisissez le code '. $this->code.' et renseigner le dans le formulaire qui appraitra lorsque vous cliquerez sur le boutton ci dessous')
                    ->action('Cliquer ici', url('/validate-account-emp' . '/' . $this->email))
                    ->line('Merci d\'utiliser nos servives! ');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
