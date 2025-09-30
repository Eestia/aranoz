<?php

namespace App\Mail;

use App\Models\Commande;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactClient extends Mailable
{
    use Queueable, SerializesModels;

    public $messageContent;
    public $commande;

    public function __construct($messageContent, Commande $commande)
    {
        $this->messageContent = $messageContent;
        $this->commande = $commande;
    }

    public function build()
    {
        return $this->subject('Message concernant votre commande #' . $this->commande->id)
                    ->view('emails.contact_client');
    }
}
