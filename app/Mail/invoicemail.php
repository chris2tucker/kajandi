<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class invoicemail extends Mailable
{
    use Queueable, SerializesModels;
protected $ordernumber;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ordernumber)
    {
        $this->ordernumber=$ordernumber;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.invoice')->with([
            'ordernumber'=>$this->ordernumber]);
    }
}
