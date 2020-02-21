<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
class resetpassword extends Mailable
{
    use Queueable, SerializesModels;
protected $email,$verify_token;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $User)
    {
        $this->email=$User->email;
        $this->verify_token=$User->remember_token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.resetpassword')->with([
            'email'=>$this->email,
            'token'=>$this->verify_token
        ]);
    }
}
