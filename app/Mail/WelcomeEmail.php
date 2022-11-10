<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $link;
    protected $user;
    protected $pass;

    public function __construct($link,$user,$pass)
    {
   
        $this->user = $user;
        $this->link = $link;
        $this->pass = $pass;


    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->user;
        $link =  $this->link;
        return $this->view('email-templates.user-welcome',['user'=>$user,'link'=>$link,'password'=>$this->pass]);
    }
}
