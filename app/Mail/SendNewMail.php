<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendNewMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The lead instance.
     *
     * @var Lead
     */
	public $lead;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($_lead)
    {
        // dati input mail (vengono dal form)
		$this->lead = $_lead;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
		return $this
			// [eventualmente] invio notifica al contattatore (da implementare)
			->replyTo($this->lead->email)
			// invio email a commerciale@boolpress.it (messaggio contatto)
			->view('emails.message-request');
    }
}
