<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
class validationMail extends Mailable
{
    use Queueable, SerializesModels;
protected $email,$verify_token;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->email=$user->email;
        $this->verify_token=$user->verification_token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.customervalidation')->with([
            'email'=>$this->email,
            'token'=>$this->verify_token
        ]);
    }
}
