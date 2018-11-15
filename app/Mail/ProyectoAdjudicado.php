<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProyectoAdjudicado extends Mailable
{
    use Queueable, SerializesModels;

    protected $licitacion;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($licitacion)
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
        return $this->view('mails.adjudicado', compact('licitacion'));
    }
}
