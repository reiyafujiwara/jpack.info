<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EntryMail extends Mailable
{
    use Queueable, SerializesModels;

   protected $SfParam;

    /**
     * Create a new message instance.
     *
     * @return void
     */


    public function __construct($SfParam){
        $this->contact = $SfParam;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){
        return $this->
            from('salesforce@js-c.co.jp')
            ->subject('Jボックス受付完了')
            ->view('emails.SendMail')
            ->with(['contact' => $this->contact]);
    }
}
