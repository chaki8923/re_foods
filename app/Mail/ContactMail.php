<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $title;
    protected $text;
    protected $email;
    protected $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($text,$email,$name)
    {
        $this->title = sprintf('%sさんからのお問い合わせ。', $email);
        $this->text = $text;
        $this->email = $email;
        $this->name = $name;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->text('foods.sendmail')
        ->subject($this->title)
        ->with(['text'=>$this->text,'name'=>$this->name,'email'=>$this->email]);
    }
}
