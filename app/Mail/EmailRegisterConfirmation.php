<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailRegisterConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $link = url('/api/auth/registro/ativar/' . $this->user->id . '/' . $this->user->token);
        return $this->view('emails.registerconfirmation')->with([
            'nome' =>  $this->user->name,
            'email' => $this->user->link,
            'link' => $link,
            'datahora' => now()->setTimezone('America/Sao_Paulo')->format('d-m-Y H:i:s')

        ]);
    }
}
