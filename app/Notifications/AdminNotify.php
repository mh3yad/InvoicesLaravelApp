<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminNotify extends Notification implements ShouldQueue
{
    use Queueable;

    private $invoice;

    /**
     * Create a new notification instance.
     *
     * @param $user
     */

    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }

    public function via($notifiable)
    {
        return ['mail','database'];
    }

    public function toMail($notifiable)
    {
        $url = url('/invoices/'.$this->invoice->id);
        return (new MailMessage)
            ->greeting('Peace upon you')
            ->line(auth()->user()->name. ' has added new invoice')
            ->action(' show ',$url)
            ->line('salam');

    }

    public function toDatabase($notifiable)
    {
        return [
            'createdBy' => auth()->user()->name,
            'invoice_number'=>$this->invoice->invoice_number,
            'url'=>url('/invoices/'.$this->invoice->id),

        ];
    }
}
