<?php

namespace App\Mail;

use App\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Mailer extends Mailable
{
    use Queueable, SerializesModels;

    protected $invoices;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        $invoices = Invoice::all();
        $this->invoices = $invoices;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.email')

            ->with([
                'invoices'=>$this->invoices
            ])->attach('Attachments/1/1.png');
    }
}
