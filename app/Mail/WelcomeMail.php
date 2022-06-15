<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\EmailTemplate;


class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;

    public function __construct($user)
    {
        $this->user= $user;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
    
        $template = EmailTemplate::where('id' , '=' , '7')->select('template_content')->first();
        $template = str_replace("{#first_name#}",$this->user->name,$template->template_content);
        $template = str_replace("{#ibm#}",$this->user->ibm,$template);
        $template = str_replace("{#email#}",$this->user->email,$template);
        return $this->subject('Welcome Email')->view('templates.welcome_email' , compact('template'));
    }
}
