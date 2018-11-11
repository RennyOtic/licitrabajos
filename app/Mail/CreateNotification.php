<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $licitacion;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($licitacion = null)
    {
        $this->licitacion = $licitacion;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $licitacion = $this->licitacion;
        $subject = 'Nueva Licitación: ' . $licitacion->nombre;
        return $this->view('mails.create_licitacion', compact('licitacion'))->subject($subject);
    }
}
