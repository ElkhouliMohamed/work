<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Rdv;

class RdvCancelled extends Notification implements ShouldQueue
{
    use Queueable;

    protected $rdv;

    /**
     * Create a new notification instance.
     */
    public function __construct(Rdv $rdv)
    {
        $this->rdv = $rdv;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['mail', 'database']; // Adjust channels as needed (e.g., 'slack', 'sms')
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Rendez-vous Annulé')
            ->line('Le rendez-vous planifié pour le ' . $this->rdv->formatted_date . ' a été annulé.')
            ->line('Détails :')
            ->line('Contact : ' . $this->rdv->contact->prenom . ' ' . $this->rdv->contact->nom)
            ->line('Type : ' . $this->rdv->type)
            ->action('Voir le rendez-vous', url(route('rdvs.show', $this->rdv)));
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        return [
            'rdv_id' => $this->rdv->id,
            'message' => 'Le rendez-vous du ' . $this->rdv->formatted_date . ' a été annulé.',
            'url' => route('rdvs.show', $this->rdv),
        ];
    }
}
