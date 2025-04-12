<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Rdv;

class RdvCompleted extends Notification implements ShouldQueue
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
    public function via(object $notifiable): array
    {
        return ['mail', 'database']; // You can adjust channels (e.g., 'slack', 'sms')
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Rendez-vous Terminé')
            ->line('Le rendez-vous planifié pour le ' . $this->rdv->formatted_date . ' a été marqué comme terminé.')
            ->line('Détails :')
            ->line('Contact : ' . $this->rdv->contact->prenom . ' ' . $this->rdv->contact->nom)
            ->line('Type : ' . $this->rdv->type)
            ->action('Voir le rendez-vous', url(route('rdvs.show', $this->rdv)));
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'rdv_id' => $this->rdv->id,
            'message' => 'Le rendez-vous du ' . $this->rdv->formatted_date . ' a été terminé.',
            'url' => route('rdvs.show', $this->rdv),
        ];
    }
}
