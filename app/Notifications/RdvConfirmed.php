<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Rdv;

class RdvConfirmed extends Notification implements ShouldQueue
{
    use Queueable;

    protected $rdv;

    public function __construct(Rdv $rdv)
    {
        $this->rdv = $rdv;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Rendez-vous Confirmé')
            ->line('Le rendez-vous planifié pour le ' . $this->rdv->formatted_date . ' a été confirmé.')
            ->line('Détails :')
            ->line('Contact : ' . $this->rdv->contact->prenom . ' ' . $this->rdv->contact->nom)
            ->line('Type : ' . $this->rdv->type)
            ->action('Voir le rendez-vous', url(route('rdvs.show', $this->rdv)));
    }

    public function toArray($notifiable): array
    {
        return [
            'rdv_id' => $this->rdv->id,
            'message' => 'Le rendez-vous du ' . $this->rdv->formatted_date . ' a été confirmé.',
            'url' => route('rdvs.show', $this->rdv),
        ];
    }
}
