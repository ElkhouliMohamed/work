<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommissionRequest extends Mailable
{
use Queueable, SerializesModels;

public $commission;
public $freelancer;

public function __construct($commission, $freelancer)
{
$this->commission = $commission;
$this->freelancer = $freelancer;
}

public function build()
{
return $this->subject('Demande de Paiement de Commission')
->view('emails.commission_request');
}
}
