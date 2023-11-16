<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DiscountCodeEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
       //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subjectData="Discount Code";
        $data = [
            "message"=>"Your Discound Code for your next order is:",
            "code"=>"WELCOME5"
        ];
        
        return $this->from('email@example.com','e-commerce')
        ->subject($subjectData)
        ->view('emails.discount-code-template')
        ->with('data',$data);
    }
}
