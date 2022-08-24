<?php

namespace App\Mail;

use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnviaPIN extends Mailable
{
    use Queueable, SerializesModels;
    public $student, $pin;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $pin)
    {
        $this->student = Student::where("email", $email)->first();
        $this->pin = $pin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->bcc("informatica@saucache.cl")->subject("PIN Elecciones")->view('emails.enviaPIN');
    }
}
