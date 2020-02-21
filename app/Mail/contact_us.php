<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class contact_us extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $name;
    protected $email;
    protected $message;
    public function __construct($name,$email,$message)
    {
        $this->name=$name;
        $this->email=$email;
        $this->message=$message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.contact_us')->with([
            'name_person'=>$this->name,
            'email_person'=>$this->email,
            'message_person'=>$this->message]);
    }
}
